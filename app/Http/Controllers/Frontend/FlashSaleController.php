<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    protected $flashSales;
    public function __construct(FlashSale $flashSale)
    {
        $this->flashSales = $flashSale;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeFlashSale = $this->flashSales->isActiveFlashSales();
        if ($activeFlashSale) {
            $flashSaleProducts = Product::activeFlashSale()
                ->with('flashSales')
                ->paginate(12);

            return view('frontend.pages.flashsales.index', [
                'flashSaleProducts' => $flashSaleProducts,
                'activeFlashSale' => $activeFlashSale
            ]);
        } else {
            return view('frontend.pages.flashsales.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
