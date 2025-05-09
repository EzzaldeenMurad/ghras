<?php

namespace App\Http\Controllers\Dashboard\Seller;

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
    public function index()
    {
        $products = Product::with('images')->where('user_id', Auth::id())->latest()->get();
        // foreach ($products as $product) {
        // $product->image_url = $product->images()->first()->image_url;
        // dd($product->images()->first()->image_url);
        // }

        return view('dashboard.seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.seller.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'price' => 'required|numeric|min:0',
    //         'category_id' => 'required|exists:categories,id',
    //         'description' => 'nullable|string',
    //         'images' => 'nullable|array',
    //     ]);
    //     dd($request->all());
    //     $data = [
    //         'name' => $request->name,
    //         'price' => $request->price,
    //         'category_id' => $request->category_id,
    //         'user_id' => Auth::id(), // Set the current authenticated user as the owner
    //         'description' => $request->description,
    //     ];

    //     if ($request->hasFile('image_url')) {
    //         $image = $request->file('image_url');
    //         $imageName = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
    //         $data['image_url'] = $image->storeAs('products', $imageName, 'public');
    //     }

    //     Product::create($data);

    //     return redirect()->route('seller.products.index')
    //         ->with('success', 'تم إضافة المنتج بنجاح');
    // }

    // In the store method
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'description' => $request->description,
        ]);
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);

                $product->images()->create([
                    'image_url' => 'images/products/' . $imageName
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('seller.products.index')
                ->with('error', 'غير مصرح لك بعرض هذا المنتج');
        }

        return view('dashboard.seller.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('seller.products.index')
                ->with('error', 'غير مصرح لك بتعديل هذا المنتج');
        }

        $categories = Category::all();
        return view('dashboard.seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Product $product)
    // {
    //     // Check if the product belongs to the authenticated user
    //     if ($product->user_id !== Auth::id()) {
    //         return redirect()->route('seller.products.index')
    //             ->with('error', 'غير مصرح لك بتعديل هذا المنتج');
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'price' => 'required|numeric|min:0',
    //         'category_id' => 'required|exists:categories,id',
    //         'description' => 'nullable|string',
    //         'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $data = [
    //         'name' => $request->name,
    //         'price' => $request->price,
    //         'category_id' => $request->category_id,
    //         'description' => $request->description,
    //     ];


    //     if ($request->hasFile('image_url')) {
    //         // Delete old image if exists
    //         if ($product->identity_image && file_exists(public_path($product->images->image_url))) {
    //             unlink(public_path($product->images->image_url));
    //         }

    //         $image = $request->file('image_url');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $imagePath = 'images/products/' . $imageName;

    //         // Make sure the directory exists
    //         if (!file_exists(public_path('images/products'))) {
    //             mkdir(public_path('images/products'), 0755, true);
    //         }

    //         $image->move(public_path('images/products'), $imageName);
    //         $product->images->image_url = $imagePath;
    //     }

    //     $product->update($data);

    //     return redirect()->route('seller.products.index')
    //         ->with('success', 'تم تحديث المنتج بنجاح');
    // }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('seller.products.index')
                ->with('error', 'غير مصرح لك بحذف هذا المنتج');
        }

        // Delete product image
        if ($product->image_url && file_exists(public_path($product->image_url))) {
            unlink(public_path($product->image_url));
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
}
