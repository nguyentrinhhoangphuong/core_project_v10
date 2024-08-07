<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon as MainMoDel;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends AdminController
{
    public function __construct(MainMoDel $model)
    {
        parent::__construct($model);
        $this->routeName = 'coupon';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        $this->controllerName = 'coupon';
        $this->pathViewController = 'admin.pages.coupon.';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = MainMoDel::all();
        return view($this->pathViewController . 'index', [
            'title' =>  'Danh sách coupon',
            'items' =>  $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->pathViewController . 'create', [
            'title' =>  'Tạo coupon',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|numeric',
            'min_order_amount' => 'required|numeric',
            'max_discount_amount' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        MainMoDel::create($data);
        return redirect()->route('admin.coupon.index')->with('success', 'Mã giảm giá đã được tạo thành công.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($item)
    {
        $item = MainMoDel::findOrFail($item);
        return view($this->pathViewController . 'edit', [
            'title' =>  'Cập nhật coupon: ' . $item->code,
            'item' =>  $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $item)
    {
        $request->validate([
            'code' => 'required',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|numeric',
            'min_order_amount' => 'required|numeric',
            'max_discount_amount' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date',
            'is_active' => 'boolean'
        ]);
        $coupon = Coupon::findOrFail($item);
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $coupon->update($data);
        return redirect()->route('admin.coupon.index')->with('success', 'Mã giảm giá đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($item)
    {
        $coupon = Coupon::findOrFail($item);
        $coupon->delete();
        return redirect()->route('admin.coupon.index')->with('success', 'Mã giảm giá đã được xóa thành công.');
    }
}
