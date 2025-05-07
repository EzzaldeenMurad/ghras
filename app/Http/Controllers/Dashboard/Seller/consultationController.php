<?php

namespace App\Http\Controllers\Dashboard\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ConsultantOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class consultationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all consultations for the current seller with consultant information
        // $consultations = ConsultantOrder::where('seller_id', $user->id)
        //     ->with('consultation')
        //     ->latest()
        //     ->get();
        $consultations =    ConsultantOrder::with('consultation.consultant')->whereHas(
            'seller',
            function ($query) use ($user) {
                $query->where('id', $user->id);
            }
        )->latest()->get();
        // dd($consultations);
        return view('dashboard.seller.consultations', compact('consultations'));
    }
    public function cancelledOrder(int $id)
    {
        $consultation = ConsultantOrder::findOrFail($id);
        $consultation->status = 'cancelled';
        $consultation->save();

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
}
