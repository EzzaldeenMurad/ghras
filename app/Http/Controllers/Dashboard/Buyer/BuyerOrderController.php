<?php

namespace App\Http\Controllers\Dashboard\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ConsultantOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BuyerOrderController extends Controller
{
    /**
     * Display a listing of the seller's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all orders for the current user
        $orders = Order::with(['items.product.user'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.buyer.mysells', compact('orders'));
    }
    public function updateOrder(Request $request)
    {
        $order = ConsultantOrder::findOrFail($request->order_id);

        if ($request->status === 'accepted') {
            $order->status = 'accepted';
        } elseif ($request->status === 'cancelled') {
            $order->status = 'cancelled';
        }

        $order->save();

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
}
