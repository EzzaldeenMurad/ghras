@extends('layouts.master')

@section('title', 'بيانات الدفع')

@section('css')
    <style>
        :root {
            --primary-bg: #F4E3CB;
            --card-bg: #ffffff;
            --primary-btn: #D2691E;
            --primary-btn-hover: #B35A1F;
            --text-color: #333333;
            --border-color: #E0D0B8;
        }

        /* body {
                                                                                                                                                            background-color: var(--primary-bg);
                                                                                                                                                            min-height: 100vh;
                                                                                                                                                            display: flex;
                                                                                                                                                            flex-direction: column;
                                                                                                                                                        } */

        .payment-container {
            margin-top: 3rem;
            margin-bottom: 3rem;
        }



        .payment-title {
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.8rem;
        }

        .form-control {
            border: 1px solid var(--border-color);
            padding: 0.8rem 1rem;
            border-radius: 8px;
            background-color: #FAF5EB !important;
            margin-bottom: 1.2rem;
        }

        .form-control:focus {
            border-color: #D2691E;
            box-shadow: 0 0 0 0.2rem rgba(210, 105, 30, 0.25);
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .payment-btn {
            background-color: var(--primary-btn);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .payment-btn:hover {
            background-color: var(--primary-btn-hover);
            transform: translateY(-2px);
        }

        .summary-section {
            /* background-color: #FAF5EB; */
            border-radius: 12px;
            padding: 1.5rem;
            height: 100%;
        }

        .summary-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.8rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .summary-total {
            font-weight: 700;
            border-top: 1px solid var(--border-color);
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .card-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .input-group-text {
            background-color: #FAFAFA;
            border: 1px solid var(--border-color);
            border-right: none;
        }

        .expiry-date-group {
            display: flex;
            gap: 0.5rem;
        }

        .expiry-date-group .form-control {
            text-align: center;
        }

        @media (max-width: 767.98px) {
            .payment-card {
                padding: 1.5rem;
            }

            .summary-section {
                margin-top: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container payment-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="payment-card">
                    <h2 class="payment-title">بيانات الدفع</h2>

                    <div class="row">
                        <!-- Payment Form (Right Side) -->
                        <div class="col-md-7 mb-4 mb-md-0">
                            <form id="payment-form">
                                @csrf

                                <div class="mb-3">
                                    <label for="cardholder-name" class="form-label">الاسم</label>
                                    <input type="text" id="cardholder-name" class="form-control"
                                        placeholder="اسمك في البطاقة" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">رقم البطاقة</label>
                                    <div id="card-number-element" class="StripeElement form-control"></div>
                                    <div id="card-number-error" class="text-danger mt-1"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ الانتهاء</label>
                                        <div id="card-expiry-element" class="StripeElement form-control"></div>
                                        <div id="card-expiry-error" class="text-danger mt-1"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CVV</label>
                                        <div id="card-cvc-element" class="StripeElement form-control"></div>
                                        <div id="card-cvc-error" class="text-danger mt-1"></div>
                                    </div>
                                </div>
                                <div id="card-errors" role="alert"></div>
                                <button id="submit-button" class="payment-btn w-100" type="submit">
                                    <span id="button-text">تأكيد الدفع</span>
                                    <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>

                        <!-- Summary Section (Left Side) -->
                        <div class="col-md-5">
                            <div class="summary-section">
                                <h5 class="summary-title">ملخص الدفع</h5>

                                <div class="summary-item">
                                    <span>سعر الاستشارة:</span>
                                    <span>{{ $order->consultation->price }}</span>
                                </div>

                                <div class="summary-item">
                                    <span>الضريبة:</span>
                                    <span>{{ $vat }}</span>
                                </div>

                                <div class="summary-item summary-total">
                                    <span>الإجمالي:</span>
                                    <span>{{ $totalPrice }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripe = Stripe("{{ env('STRIPE_KEY') }}");
            const elements = stripe.elements();

            const style = {
                base: {
                    color: '#32325d',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#e5424d'
                },
                // iconStyle: 'solid'
            };


            const cardNumber = elements.create('cardNumber', {
                style,
                iconStyle: 'solid'
            });
            const cardExpiry = elements.create('cardExpiry', {
                style
            });
            const cardCvc = elements.create('cardCvc', {
                style
            });


            cardNumber.mount('#card-number-element');
            cardExpiry.mount('#card-expiry-element');
            cardCvc.mount('#card-cvc-element');
            // حدد كل العناصر الخاصة بالأخطاء
            const errorContainers = {
                cardNumber: document.getElementById('card-number-error'),
                cardExpiry: document.getElementById('card-expiry-error'),
                cardCvc: document.getElementById('card-cvc-error'),
            };

            const errorMessages = {
                'card_number': 'يرجى إدخال رقم بطاقة صالح.',
                'card_expiry': 'يرجى إدخال تاريخ انتهاء صالح.',
                'card_cvc': 'يرجى إدخال رمز CVV صالح.'
            };

            // تعديل الكود للتعامل مع الأخطاء الخاصة بكل حقل
            function handleStripeError(event, field) {
                if (event.error) {
                    if (field === 'cardNumber') {
                        errorContainers.cardNumber.textContent = errorMessages.card_number || event.error.message;
                    } else if (field === 'cardExpiry') {
                        errorContainers.cardExpiry.textContent = errorMessages.card_expiry || event.error.message;
                    } else if (field === 'cardCvc') {
                        errorContainers.cardCvc.textContent = errorMessages.card_cvc || event.error.message;
                    }
                } else {
                    errorContainers[field].textContent = '';
                }
            }


            // ربط الأحداث بكل حقل
            cardNumber.on('change', event => handleStripeError(event, 'cardNumber'));
            cardExpiry.on('change', event => handleStripeError(event, 'cardExpiry'));
            cardCvc.on('change', event => {
                handleStripeError(event, 'cardCvc');
                // في حالة وجود خطأ في CVV
                if (event.error) {
                    if (event.error.code === 'invalid_cvc') {
                        errorContainers.cardCvc.textContent = 'يرجى إدخال رمز CVV صالح.';
                    }
                }
            });


            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('spinner');


            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                const cardholderName = document.getElementById('cardholder-name').value;

                const {
                    paymentMethod,
                    error
                } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardNumber,
                    billing_details: {
                        name: cardholderName,
                    },
                });

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                } else {
                    // إرسال إلى السيرفر
                    fetch("{{ route('stripe.payment') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                            },
                            body: JSON.stringify({
                                payment_method_id: paymentMethod.id,
                                amount: 5000 // مثال: 50 ريال (5000 هللة)
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert("تمت العملية بنجاح");
                            } else {
                                document.getElementById('card-errors').textContent = data.message;
                            }
                        });
                }
            });
        });
    </script>

@endsection
