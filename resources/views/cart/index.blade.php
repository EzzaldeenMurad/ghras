@extends('layouts.master')

@section('title', 'سلة المشتريات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@endsection

@section('content')
    <div class="cart-container container mt-5">
        <div class="d-flex align-items-center me-5">
            <a href="{{ route('home') }}" class="btn btn-primary">رجوع</a>
        </div>
        <div>
            <h1 class="tiltle text-center mb-5">سلة المشتريات</h1>

            @if ($cartItems->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>صورة المنتج</th>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>المجموع</th>
                            <th>حذف المنتج</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr data-id="{{ $item->rowId }}">
                                <td>
                                    <div class="product-img ">
                                        @if (isset($item->options['image']))
                                            <img src="{{ asset($item->options['image']) }}" alt="{{ $item->name }}"
                                                class="w-10 h-10">
                                        @else
                                            <div class="no-image">لا توجد صورة</div>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <div class="quantity-control d-flex">
                                        <button class="quantity-btn minus p-1" data-id="{{ $item->rowId }}">-</button>
                                        <input type="text" min="1" class="quantity-input text-center"
                                            style="width: 40px;" value="{{ $item->qty }}" data-id="{{ $item->rowId }}">
                                        <button class="quantity-btn plus p-1" data-id="{{ $item->rowId }}">+</button>
                                    </div>
                                </td>
                                <td>{{ $item->price }} ريال</td>
                                <td class="item-subtotal">{{ $item->subtotal }} ريال</td>
                                <td>
                                    <a href="{{ route('cart.remove', $item->rowId) }}" class="delete-btn text-decoration-none">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="cart-summary">
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="summary-card">
                                <h4>ملخص السلة</h4>
                                <div class="d-flex justify-content-between">
                                    <span>المجموع الفرعي:</span>
                                    <span id="cart-subtotal">{{ Cart::instance()->subtotal() }} ريال</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>الضريبة:</span>
                                    <span id="cart-tax">{{ Cart::instance()->tax() }} ريال</span>
                                </div>
                                <div class="d-flex justify-content-between total">
                                    <span>المجموع:</span>
                                    <span id="cart-total">{{ Cart::instance()->total() }} ريال</span>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger">تفريغ السلة</a>
                                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary">إتمام الطلب</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-cart text-center">
                    <i class="fas fa-shopping-cart fa-4x mb-3"></i>
                    <h3>سلة المشتريات فارغة</h3>
                    <p>لم تقم بإضافة أي منتجات إلى سلة المشتريات بعد.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">تصفح المنتجات</a>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Helper: Extract numbers from a string (handles "1,000.50 ريال" → 1000.50)
            function parsePrice(priceString) {
                return parseFloat(priceString.replace(/[^0-9.-]/g, ''));
            }

            // Update quantity with plus button
            $('.quantity-btn.plus').on('click', function() {
                const rowId = $(this).data('id');
                const input = $(this).siblings('.quantity-input');
                const newQty = parseInt(input.val()) + 1;
                input.val(newQty);
                updateCartItem(rowId, newQty);
            });

            // Update quantity with minus button (minimum 1)
            $('.quantity-btn.minus').on('click', function() {
                const rowId = $(this).data('id');
                const input = $(this).siblings('.quantity-input');
                const newQty = Math.max(1, parseInt(input.val()) - 1);
                input.val(newQty);
                updateCartItem(rowId, newQty);
            });

            // Handle direct input change
            $('.quantity-input').on('change', function() {
                const rowId = $(this).data('id');
                let qty = parseInt($(this).val()) || 1;
                qty = Math.max(1, qty);
                $(this).val(qty);
                updateCartItem(rowId, qty);
            });

            // AJAX: Update cart item
            function updateCartItem(rowId, quantity) {
                const $row = $(`tr[data-id="${rowId}"]`);
                $row.addClass('updating');

                $.ajax({
                    url: '{{ route('cart.update') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        rowId: rowId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update item subtotal (use backend-calculated value)
                            $row.find('.item-subtotal').text(response.itemSubtotal + ' ريال');

                            // Update cart totals (from backend)
                            $('#cart-subtotal').text(response.subtotal + ' ريال');
                            $('#cart-total').text(response.total + ' ريال');
                        }
                    },
                    error: function(xhr) {
                        alert('Error: Could not update quantity.');
                        console.error("AJAX Error:", xhr.responseText);
                    },
                    complete: function() {
                        $row.removeClass('updating');
                    }
                });
            }
        });
    </script>
@endsection