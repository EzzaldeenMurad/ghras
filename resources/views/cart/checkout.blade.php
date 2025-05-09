@extends('layouts.master-with-header')

@section('title', 'إتمام الطلب')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
    <style>
        #payment-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
            display: none;
        }

        #payment-message.visible {
            display: block;
        }

        .card {
            box-shadow: 0px 2.71px 12.21px 0px #4B465C1A;
            background-color: transparent;
            border: none
        }

        textarea {
            background-color: transparent !important;
            border: 1px solid var(--border-color) !important;
        }

        .list-group-item {
            box-shadow: 0px 2.71px 12.21px 0px #4B465C1A;
            border-bottom: 1px solid var(--border-color) !important;

            background-color: transparent;
        }

        .btn-primary {
            background-color: var(--primary-btn) !important;
            border: none;
            color: white;
            /* padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            margin-top: 1rem; */

        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header ">
                        <h4>معلومات الشحن</h4>
                    </div>
                    <div class="card-body">
                        <form id="payment-form">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">الاسم الكامل</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">رقم الهاتف</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label">المدينة</label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">العنوان</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header ">
                                    <h4>معلومات الدفع</h4>
                                </div>
                                <div class="card-body">
                                    <div id="payment-element">
                                        <!-- Stripe Elements will be inserted here -->
                                    </div>
                                    <div id="payment-message"></div>
                                </div>
                            </div>

                            <button id="submit-button" type="submit"
                                class="btn  btn-primary mt-4 w-100">إتمام
                                الطلب</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header ">
                        <h4>ملخص الطلب</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            @foreach (Cart::instance()->content() as $item)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">{{ $item->name }} ({{ $item->qty }})</h6>
                                    </div>
                                    <span class="text-muted">{{ $item->subtotal }} ريال</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between">
                                <span>المجموع</span>
                                <strong>{{ Cart::instance()->total() }} ريال</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const paymentMessage = document.getElementById('payment-message');

            // Disable the submit button until Stripe is loaded
            submitButton.disabled = true;
            submitButton.innerHTML = 'جاري التحميل...';

            try {
                // First, save the order details to session and get a payment intent
                const orderData = {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                    address: document.getElementById('address').value,
                    city: document.getElementById('city').value,
                    amount: '{{ Cart::instance()->total() }}'
                };

                // Create a payment intent
                const response = await fetch('{{ route('payment.create-intent') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: '{{ Cart::instance()->total() }}'
                    })
                });

                const data = await response.json();

                if (data.error) {
                    showError(data.error);
                    return;
                }

                // Initialize Stripe
                const stripe = Stripe('{{ env('STRIPE_KEY') }}');

                // Create Elements instance
                const elements = stripe.elements({
                    clientSecret: data.clientSecret,
                    locale: 'ar',
                    appearance: {
                        theme: 'stripe',
                        variables: {
                            colorPrimary: '#0d6efd',
                            colorBackground: '#FFFFFF00',
                            colorText: '#333333',
                            colorDanger: '#dc3545',
                            fontFamily: 'Arial, sans-serif',
                            spacingUnit: '4px',
                            borderRadius: '8px'
                        }
                    }
                });

                // Create and mount the Payment Element
                const paymentElement = elements.create('payment', {
                    layout: {
                        type: 'tabs',
                    },
                    fields: {
                        billingDetails: {
                            country: 'never'
                        }
                    },
                    wallets: {
                        applePay: 'never',
                        googlePay: 'never',
                        link: 'never'
                    }
                });

                paymentElement.mount('#payment-element');

                // Enable the submit button
                submitButton.disabled = false;
                submitButton.innerHTML = 'إتمام الطلب';

                // Handle form submission
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    // Validate form fields
                    const requiredFields = ['name', 'email', 'phone', 'city', 'address'];
                    for (const field of requiredFields) {
                        const element = document.getElementById(field);
                        if (!element.value.trim()) {
                            showError(`الرجاء إدخال ${element.labels[0].textContent}`);
                            element.focus();
                            return;
                        }
                    }

                    // Disable the submit button during processing
                    submitButton.disabled = true;
                    submitButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري المعالجة...';

                    // Save order data to session
                    try {
                        const orderResponse = await fetch('{{ route('payment.process') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                name: document.getElementById('name').value,
                                email: document.getElementById('email').value,
                                phone: document.getElementById('phone').value,
                                address: document.getElementById('address').value,
                                city: document.getElementById('city').value
                            })
                        });

                        // Confirm the payment
                        const {
                            error
                        } = await stripe.confirmPayment({
                            elements,
                            confirmParams: {
                                return_url: '{{ route('payment.callback') }}',
                                payment_method_data: {
                                    billing_details: {
                                        name: document.getElementById('name').value,
                                        email: document.getElementById('email').value,
                                        phone: document.getElementById('phone').value,
                                        address: {
                                            line1: document.getElementById('address').value,
                                            city: document.getElementById('city').value,
                                            country: 'SA'
                                        }
                                    }
                                }
                            }
                        });

                        // If there is an error, display it
                        if (error) {
                            showError(error.message);
                            submitButton.disabled = false;
                            submitButton.innerHTML = 'إتمام الطلب';
                        }
                        // If successful, the page will be redirected to the return_url

                    } catch (error) {
                        console.error('Error:', error);
                        showError('حدث خطأ أثناء معالجة الطلب. يرجى المحاولة مرة أخرى.');
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'إتمام الطلب';
                    }
                });

            } catch (error) {
                console.error('Error:', error);
                showError('حدث خطأ أثناء تهيئة نموذج الدفع. يرجى المحاولة مرة أخرى.');
                submitButton.disabled = false;
                submitButton.innerHTML = 'إتمام الطلب';
            }

            // Helper function to show error messages
            function showError(message) {
                paymentMessage.textContent = message;
                paymentMessage.style.display = 'block';

                // Scroll to the error message
                paymentMessage.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    </script>
@endsection
