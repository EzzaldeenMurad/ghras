<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConsultantOrder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Surfsidemedia\Shoppingcart\Facades\Cart;
// use Stripe\PaymentIntent;

class paymentController extends Controller
{
    /**
     * Display a listing of the seller's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        $order = ConsultantOrder::with('consultation')->findOrFail($id);
        $vat = 0;
        $totalPrice = $vat + $order->consultation->price;
        $orderId = $order->id;
        $price = $order->consultation->price;
        return view('payment.index', compact('orderId', 'price', 'totalPrice', 'vat'));
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
            'order_id' => 'nullable',
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
                    'order_id' => $request->order_id ?? null,
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
                $save = $this->savePaymentConsultantOrder($paymentIntent,  $request->order_id);

                session()->flash('success', 'تم عملية الدفع بنجاح');

                return response()->json([
                    'success' => true,
                    'payment_id' => $paymentIntent->id,
                    // 'order_id' => $save
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
                // Get the order_id from metadata
                $orderId = $paymentIntent->metadata->order_id ?? null;

                // Save payment to database
                dd($paymentIntent);
                $save = $this->savePaymentConsultantOrder($paymentIntent, $orderId);

                return response()->json([
                    'success' => true,
                    'payment_id' => $paymentIntent->id,
                    // 'order_id' => $save
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
    private function savePaymentConsultantOrder($paymentIntent, $orderId)
    {
        try {

            $order = ConsultantOrder::find($orderId);

            $payment =    Payment::create([
                'amount' => $paymentIntent->amount,
                'status' => $paymentIntent->status,
                'payment_id' => $paymentIntent->id,
                'payment_method' => 'card',
                'user_id' => auth()->id(),
                'consultant_order_id' => $orderId,
            ]);

            $dd =  $order->update([
                'status' => 'paid'
            ]);
            // dd($dd);
            return $payment;
        } catch (\Exception $e) {
            // Log the error but don't interrupt the user flow
            Log::error('Error saving payment record: ' . $e->getMessage());
        }
    }

    // ===============


    /**
     * Process the payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
        ]);

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $amount = (int)(Cart::instance()->total() * 100); // Convert to cents

            // Store order data in session BEFORE creating payment intent
            session()->put('order_data', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'amount' => Cart::instance()->total(),
            ]);

            // Make sure session is saved immediately
            session()->save();

            // $paymentIntent = PaymentIntent::create([
            //     'amount' => $amount,
            //     'currency' => 'sar',
            //     'metadata' => [
            //         'user_id' => auth()->id() ?? 'guest',
            //         'name' => $request->name,
            //         'email' => $request->email,
            //         'phone' => $request->phone,
            //         'address' => $request->address,
            //         'city' => $request->city,
            //     ],
            // ]);
            $this->callback($request);
            // return response()->json([
            //     'clientSecret' => $paymentIntent->client_secret,
            // ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        $paymentIntentId = $request->payment_intent;
        $orderData = session()->get('order_data');

        // Log for debugging
        Log::info('Payment callback received', [
            'payment_intent' => $paymentIntentId,
            'order_data' => $orderData,
            'session_id' => session()->getId()
        ]);

        // Remove the dd() statement that was interrupting the flow
        // dd($paymentIntentId);

        if (!$paymentIntentId || !$orderData) {
            // If order data is missing, try to get it from the payment intent metadata
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

                if (!$orderData && isset($paymentIntent->metadata->name)) {
                    $orderData = [
                        'name' => $paymentIntent->metadata->name,
                        'email' => $paymentIntent->metadata->email,
                        'phone' => $paymentIntent->metadata->phone,
                        'address' => $paymentIntent->metadata->address,
                        'city' => $paymentIntent->metadata->city,
                        'amount' => $paymentIntent->amount / 100,
                    ];

                    // Store it in session for future use
                    session()->put('order_data', $orderData);
                }

                // If still no order data, redirect to cart
                if (!$orderData) {
                    return redirect()->route('cart.index')->with('error', 'حدث خطأ أثناء معالجة الدفع: بيانات الطلب غير متوفرة');
                }
            } catch (\Exception $e) {
                Log::error('Error retrieving payment intent: ' . $e->getMessage());
                return redirect()->route('cart.index')->with('error', 'حدث خطأ أثناء معالجة الدفع');
            }
        }

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status === 'succeeded') {
                // Create order with the retrieved data
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'name' => $orderData['name'],
                    'email' => $orderData['email'],
                    'phone' => $orderData['phone'],
                    'address' => $orderData['address'],
                    'city' => $orderData['city'],
                    'total' => $orderData['amount'],
                    'payment_id' => $paymentIntentId,
                    'status' => 'paid',
                ]);

                // Create order items
                foreach (Cart::instance()->content() as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->id,
                        'quantity' => $item->qty,
                        'price' => $item->price,
                    ]);
                }

                // Create payment record
                Payment::create([
                    'payment_id' => $paymentIntentId,
                    'user_id' => auth()->id() ?? null,
                    'amount' => $orderData['amount'],
                    'status' => 'completed',
                    'payment_method' => 'stripe',
                ]);

                // Clear cart and session data
                Cart::instance()->destroy();
                session()->forget('order_data');

                return redirect()->route('orders.success', $order->id)->with('success', 'تم إتمام الطلب بنجاح');
            } else {
                return redirect()->route('cart.checkout')->with('error', 'فشلت عملية الدفع، يرجى المحاولة مرة أخرى');
            }
        } catch (ApiErrorException $e) {
            Log::error('Stripe callback error: ' . $e->getMessage());
            return redirect()->route('cart.checkout')->with('error', 'حدث خطأ أثناء معالجة الدفع');
        }
    }
    // ... existing code ...

    /**
     * Display the order success page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        // Check if the order belongs to the authenticated user
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }

    /**
     * Create a payment intent for Stripe Elements
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createIntent(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $amount = (int)($request->amount * 100); // Convert to cents

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'sar',
                'metadata' => [
                    'user_id' => auth()->id() ?? 'guest',
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
