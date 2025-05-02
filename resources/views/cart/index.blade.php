@extends('layouts.master')

@section('title', 'سلة المشتريات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@endsection

@section('content')
    <div class="cart-container container mt-5">
        <div class="d-flex  align-items-center me-5">
            <a href="{{ route('home') }}" class="btn btn-primary">رجوع</a>
        </div>
        <div>
            <h1 class="tiltle  text-center mb-5">سلة المشتريات</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>حذف المنتج</th>
                        <th>صورة المنتج</th>
                        <th>اسم المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <button class="delete-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                        <td>
                            <div class="product-image">
                                <img src="../assets/images/img1.png" alt="تمر ">
                            </div>
                        </td>
                        <td>تمر طازج</td>
                        <td>
                            <div class="d-flex align-items-center ">
                                <button class="quantity-btn"><span class="text-quantity-btn">+</span></button>
                                <input type="text" value="1" class="quantity-input" readonly>
                                <button class="quantity-btn"><span class="text-quantity-btn">-</span></button>
                            </div>
                        </td>
                        <td>
                            <div class="old-price  text-decoration-line-through">219.00 ريال</div>
                            <div class="new-price">50 ريال</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="me-5 d-flex flex-column gap-2">
            <div class="total-container">
                <div class="total">المجموع: 0 ريال</div>
                <div class="note">* ملاحظة: هذا المجموع لا يشمل تكاليف التوصيل</div>
            </div>
            <div class="payment-button">
                <button class="btn-primary">دفع قيمة الفاتورة</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Simple cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            const quantityBtns = document.querySelectorAll('.quantity-btn');
            const quantityInput = document.querySelector('.quantity-input');
            const totalElement = document.querySelector('.total');
            const deleteBtns = document.querySelectorAll('.delete-btn');

            // Starting price
            const pricePerItem = 50;

            // Update total
            function updateTotal() {
                const quantity = parseInt(quantityInput.value);
                const total = quantity * pricePerItem;
                totalElement.textContent = `المجموع: ${total} ريال`;
            }

            // Initialize
            updateTotal();

            // Add quantity button listeners
            quantityBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    let quantity = parseInt(quantityInput.value);

                    if (this.textContent === '+') {
                        quantity += 1;
                    } else if (this.textContent === '-' && quantity > 1) {
                        quantity -= 1;
                    }

                    quantityInput.value = quantity;
                    updateTotal();
                });
            });

            // Add delete button listener
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    row.remove();
                    totalElement.textContent = 'المجموع: 0 ريال';
                });
            });
        });
    </script>
@endsection
