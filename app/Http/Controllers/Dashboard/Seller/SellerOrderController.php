<?php

namespace App\Http\Controllers\Dashboard\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    /**
     * Display a listing of orders for products sold by the seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the current seller's product IDs
        $productIds = Product::where('user_id', Auth::id())->pluck('id');
        
        // Get orders that contain the seller's products
        $orders = Order::with(['items.product.images', 'user'])
            ->whereHas('items', function($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('dashboard.seller.orders', compact('orders'));
    }

    /**
     * Update the status of an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,paid,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        
        // Verify that this order contains products from the current seller
        $productIds = Product::where('user_id', Auth::id())->pluck('id');
        $hasSellerProducts = $order->items()->whereIn('product_id', $productIds)->exists();
        
        if (!$hasSellerProducts) {
            return redirect()->back()
                ->with('error', 'غير مصرح لك بتعديل هذا الطلب');
        }
        
        $order->status = $request->status;
        $order->save();
        
        return redirect()->back()
            ->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
}