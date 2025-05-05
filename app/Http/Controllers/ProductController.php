<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the seller's products.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $products = Product::all();
    //     $categories = Category::whereNull('parent_id')
    //         ->with(['children' => function ($query) {
    //             $query->orderBy('id');
    //         }])
    //         ->orderBy('id')
    //         ->get();

    //     return view('products.index', compact('products', 'categories'));
    // }
    public function index(Request $request)
    {
        // Get all categories with their children
        $categories = Category::whereNull('parent_id')->with('children')->get();

        // Start building the query
        $query = Product::with(['images', 'category', 'user']);

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category_id)
                    ->orWhere('parent_id', $request->category_id);
            });
        }

        // Apply child category filter
        if ($request->has('child_id') && !empty($request->child_id)) {
            $query->where('category_id', $request->child_id);
        }

        // Get the products with pagination
        $products = $query->latest()->paginate(9);
        // dd($products);
        return view('products.index', compact('products', 'categories'));
    }
    public function show(int $id)
    {
        //   dd($id);
        $product = Product::with('category', 'user', 'images')->find($id);

        return view('products.show', compact('product'));
    }

    public function rate(Request $request)
    {
        $value = $request->input('value');
        $product_id = $request->input('product_id');
        $product = Product::find($product_id);

        $rating = auth()->user()->ratings()->updateOrCreate(['product_id' => $product->id], ['value' => $value]);
        return response()->json([
            'success' => true,
            'rating' => $rating->value,
            'averageRating' => $product->rate()
        ]);
    }
}
