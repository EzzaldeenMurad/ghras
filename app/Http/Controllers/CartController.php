<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display the cart contents
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartItems = Cart::content();
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Add a product to the cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Check if product is already in cart
        $duplicates = Cart::instance()->search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        });
        
        if ($duplicates->isNotEmpty()) {
            return redirect()->back()->with('error', 'المنتج موجود بالفعل في السلة');
        }
        
        Cart::instance()->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 0,
            'options' => [
                'image' => $product->images()->first() ? $product->images()->first()->image_url : null,
            ]
        ]);
        
        return redirect()->back()->with('success', 'تمت إضافة المنتج إلى السلة');
    }

    /**
     * Update the quantity of a cart item
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'rowId' => 'required',
            'quantity' => 'required|numeric|min:1'
        ]);
        
        Cart::instance()->update($request->rowId, $request->quantity);

        return response()->json([
            'success' => true,
            'itemSubtotal' => Cart::get($request->rowId)->price * $request->quantity, // Optional (if you want to update individual rows)
            'subtotal' => Cart::subtotal(), // Cart total before taxes
            'total' => Cart::total(), // Final total (after taxes/discounts)
        ]);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم تحديث الكمية',
        //     'subtotal' => Cart::instance()->subtotal(),
        //     'total' => Cart::instance()->total()
        // ]);
    }

    /**
     * Remove an item from the cart
     *
     * @param  string  $rowId
     * @return \Illuminate\Http\Response
     */
    public function remove($rowId)
    {
        Cart::instance()->remove($rowId);
        
        return redirect()->back()->with('success', 'تم إزالة المنتج من السلة');
    }

    /**
     * Clear all items from the cart
     *
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        Cart::instance()->destroy();
        
        return redirect()->back()->with('success', 'تم تفريغ السلة');
    }

    /**
     * Proceed to checkout
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        if (Cart::instance()->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }
        
        return view('cart.checkout');
    }
}