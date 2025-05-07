<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class consultantController extends Controller
{
    /**
     * Display a listing of the seller's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultants = User::where('role', 'consultant')->get();
        return view('consultants.index', compact('consultants'));
    }
    public function show(int $id)
    {
        $consultant = User::findOrFail($id);
        return view('consultants.show', compact('consultant'));
    }

    public function consultationOrder(int $id)
    {
        $consultant = User::findOrFail($id);
        return view('consultants.consultation-order', compact('consultant'));
    }
    public function consultationStore(Request $request)
    {
        $validated = $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        // dd($validated);
        $consultation = Consultation::findOrFail($validated['consultation_id']);

        $consultation->consultantOrders()->create([
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'seller_id' => auth()->user()->id,
            'status' => 'pending'
        ]);
        return redirect()->route('consultants.show', $consultation->consultant->id)->with('success', 'تم ارسال الطلب بنجاح');
    }
}
