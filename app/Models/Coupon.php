<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
        'description'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at->isPast();
    }

    public function isValid($orderTotal)
    {
        $isValid = $this->is_active
            && $this->starts_at->startOfDay()->isPast()
            && $this->expires_at->isFuture()
            && $orderTotal >= $this->min_order_amount
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit);
        return $isValid;
    }

    public function hasReachedLimit()
    {
        return !$this->is_active
            || !$this->starts_at->startOfDay()->isPast()
            || $this->expires_at->isPast()
            ||  $this->used_count >= $this->usage_limit;
    }

    public function applyDiscount($orderTotal)
    {
        if (!$this->isValid($orderTotal)) {
            return $orderTotal;
        }
        $discount = 0;
        if ($this->discount_type === 'fixed') {
            $discount = $this->max_discount_amount;
        } else { // percent
            $discount = $orderTotal * ($this->discount_value / 100);
            $discount = min($discount, $this->max_discount_amount);
        }
        return max($orderTotal - $discount, 0);
    }

    public function incrementUsage()
    {
        $this->used_count++;
        $this->save();
    }

    public function countCouponValid()
    {
        $activeCoupons = Coupon::where('is_active', true)
            ->where('expires_at', '>', Carbon::now())
            ->count();

        return $activeCoupons;
    }

    public static function getValidCouponNames($orderTotal = 0)
    {
        $validCoupons = Coupon::where('is_active', true)
            ->where('starts_at', '<=', Carbon::now())
            ->where('expires_at', '>', Carbon::now())
            ->where('min_order_amount', '<=', $orderTotal)
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereColumn('used_count', '<', 'usage_limit');
            })
            ->get();
        return $validCoupons->map(function ($coupon) {
            return [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value,
            ];
        });
    }
}
