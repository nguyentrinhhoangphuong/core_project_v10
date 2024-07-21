<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends MainModel
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'payed_at',
        'order_id'
    ];

    protected $dates = [
        'payed_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
