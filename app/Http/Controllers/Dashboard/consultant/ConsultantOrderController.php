<?php

namespace App\Http\Controllers\Dashboard\consultant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ConsultantOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConsultantOrderController extends Controller
{
    /**
     * Display a listing of the seller's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = ConsultantOrder::whereHas('consultation', function ($query) {
            $query->where('consultant_id', auth()->id());
        })->with(['consultation', 'seller'])->latest()->get();

        return view('dashboard.consultant.consultant-order', compact('orders'));
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
