<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with(['user', 'images'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['user', 'images', 'category']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete all associated images
        foreach ($product->images as $image) {
            if ($image->image_url && file_exists(public_path($image->image_url))) {
                unlink(public_path($image->image_url));
                $image->delete();
            }
        }

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
}
