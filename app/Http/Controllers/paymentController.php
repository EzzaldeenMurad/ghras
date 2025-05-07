<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConsultantOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

// use Stripe\PaymentIntent;

class paymentController extends Controller
{
    /**
     * Display a listing of the seller's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int  $id)
    {
        $order = ConsultantOrder::with('consultation')->findOrFail($id);
        $vat = 0;
        $totalPrice = $vat + $order->consultation->price;
        return view('payment.index', compact('order', 'totalPrice', 'vat'));
    }

    // public function handlePayment(Request $request)
    // {
    //     try {
    //         Stripe::setApiKey(env('STRIPE_SECRET'));

    //         $paymentIntent = PaymentIntent::create([
    //             'amount' => $request->amount, // بالـ "سنت" أو "هللة" حسب العملة
    //             'currency' => 'sar',
    //             'payment_method' => $request->payment_method_id,
    //             'confirmation_method' => 'manual',
    //             'confirm' => true,
    //         ]);

    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    public function handlePayment(Request $request)
    {
        // Check if we're confirming an existing payment intent
        if ($request->has('payment_intent_id')) {
            return $this->confirmPaymentIntent($request->payment_intent_id);
        }

        // Validate the request
        $request->validate([
            'payment_method_id' => 'required|string',
            'amount' => 'required|numeric|min:1',
            // 'invoice_id' => 'required|exists:invoices,id'
        ]);

        // dd($request->all());
        // Set your Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            // Create a PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => round($request->amount * 100), // Convert to cents
                'currency' => "SAR",
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('home'),
                'metadata' => [
                    'user_id' => auth()->id(),
                    // 'invoice_id' => $request->invoice_id ?? null,
                ]
            ]);

            // Check if payment requires additional action
            if (
                $paymentIntent->status === 'requires_action' &&
                $paymentIntent->next_action->type === 'use_stripe_sdk'
            ) {
                dd($request->all());
                // Tell the client to handle the action
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret
                ]);
            } else if ($paymentIntent->status === 'succeeded') {
                // Payment succeeded, save to database
                // $save = $this->savePaymentRecord($paymentIntent,  $request->invoice_id);

                session()->flash('success', 'تم عملية الدفع بنجاح');

                return response()->json([
                    'success' => true,
                    'payment_id' => $paymentIntent->id,
                    // 'invoice_id' => $save
                ]);
            } else {
                // Invalid status
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid PaymentIntent status: ' . $paymentIntent->status
                ]);
            }
        } catch (ApiErrorException $e) {
            // Log the error
            Log::error('Stripe API Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Payment Processing Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred. Please try again.'
            ]);
        }
    }
    private function confirmPaymentIntent($paymentIntentId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $paymentIntent->confirm();

            if ($paymentIntent->status === 'succeeded') {
                // Get the invoice_id from metadata
                $invoiceId = $paymentIntent->metadata->invoice_id ?? null;

                // Save payment to database
                dd($paymentIntent);
                // $save = $this->savePaymentRecord($paymentIntent, $invoiceId);

                return response()->json([
                    'success' => true,
                    'payment_id' => $paymentIntent->id,
                    // 'invoice_id' => $save
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment confirmation failed: ' . $paymentIntent->status
                ]);
            }
        } catch (ApiErrorException $e) {
            Log::error('Stripe API Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
