<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;


class HomeController extends Controller
{
    /**
     * Display a listing of the seller's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }
    public function show(Product $id)
    {
        // جلب المنتج مع العلاقات المرتبطة به
        $product = Product::with('category', 'user', 'images')->find($id)->first();
        // عرض المنتج في صفحة العرض
        return view('products.show', compact('product'));
    }
}
