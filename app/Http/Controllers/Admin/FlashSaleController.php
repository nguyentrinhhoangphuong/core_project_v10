<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSales = FlashSale::all();
        return view('admin.pages.flash_sales.index', [
            'title' => 'Quản lý flash sale',
            'flashSales' => $flashSales
        ]);
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.pages.flash_sales.create', [
            'title' => 'Tạo flash sale',
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'products' => 'required|array'
        ]);

        $flashSale = FlashSale::create($request->except('products'));
        $flashSale->products()->sync($request->products);

        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash Sale đã được tạo thành công');
    }

    public function edit(FlashSale $item)
    {
        $products = Product::all();
        return view('admin.pages.flash_sales.create', [
            'title' => 'Cập nhật flash sale',
            'item' => $item,
            'products' => $products,
        ]);
    }

    public function update(Request $request, FlashSale $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'products' => 'required|array'
        ]);

        $item->update($request->except('products'));
        $item->products()->sync($request->products);

        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash Sale đã cập nhật thành công');
    }

    public function destroy(FlashSale $item)
    {
        $item->delete();
        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash Sale đã cập nhật thành công');
    }
}
