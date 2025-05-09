@extends('layouts.master-with-header')

@section('title', ' سجل المشتريات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashbord.css') }}">
    <style>
        .order-details-icon {
            cursor: pointer;
            color: #d2691e;
            transition: all 0.3s;
        }

        .order-details-icon:hover {
            color: #b35a1f;
        }

        .modal-header,
        .modal-footer {
            border-color: #eee;
        }

        .order-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #ffc107;
            color: #212529;
        }

        .status-processing {
            background-color: #17a2b8;
            color: white;
        }

        .status-delivered {
            background-color: #28a745;
            color: white;
        }

        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }

        /* shipped */
        .status-shipped {
            background-color: #007bff;
            color: white;
        }

        /* paid */
        .status-paid {
            background-color: #d2691e;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('dashboard.partials.sidebar')

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card bg-transparent border-0" style="width: 97%;">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <h5 class="card-title text-center">سجل المشتريات</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>تاريخ</th>
                                    <th>المجموع</th>
                                    <th>الحالة</th>
                                    <th>التفاصيل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>{{ $order->total }} ريال</td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status }}">
                                                @switch($order->status)
                                                    @case('pending')
                                                        قيد الانتظار
                                                    @break

                                                    @case('processing')
                                                        قيد المعالجة
                                                    @break

                                                    @case('paid')
                                                        تم الدفع
                                                    @break

                                                    @case('shipped')
                                                        تم الشحن
                                                    @break

                                                    @case('delivered')
                                                        تم التوصيل
                                                    @break

                                                    @case('cancelled')
                                                        تم الغاء
                                                    @break
                                                @endswitch
                                                {{-- {{ $order->status == 'completed' ? 'مكتمل' : 'قيد المعالجة' }} --}}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <i class="fas fa-eye order-details-icon" data-bs-toggle="modal"
                                                data-bs-target="#orderModal{{ $order->id }}"></i>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد مشتريات حتى الآن</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Modals -->
        @foreach ($orders as $order)
            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1"
                aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <h5 class="modal-title ms-auto" id="orderModalLabel{{ $order->id }}">تفاصيل الطلب
                                #{{ $order->id }}</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>معلومات الشحن</h6>
                                    <p><strong>الاسم:</strong> {{ $order->name }}</p>
                                    <p><strong>البريد الإلكتروني:</strong> {{ $order->email }}</p>
                                    <p><strong>الهاتف:</strong> {{ $order->phone }}</p>
                                    <p><strong>العنوان:</strong> {{ $order->address }}</p>
                                    <p><strong>المدينة:</strong> {{ $order->city }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>معلومات الطلب</h6>
                                    <p><strong>رقم الطلب:</strong> #{{ $order->id }}</p>
                                    <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
                                    <p><strong>حالة الطلب:</strong> @switch($order->status)
                                            @case('pending')
                                                قيد الانتظار
                                            @break

                                            @case('processing')
                                                قيد المعالجة
                                            @break

                                            @case('paid')
                                                تم الدفع
                                            @break

                                            @case('shipped')
                                                تم الشحن
                                            @break

                                            @case('delivered')
                                                تم التوصيل
                                            @break

                                            @case('cancelled')
                                                تم الغاء
                                            @break
                                        @endswitch
                                    </p>
                                    <p><strong>طريقة الدفع:</strong> بطاقة ائتمان</p>
                                    <p><strong>المجموع:</strong> {{ $order->total }} ريال</p>
                                </div>
                            </div>

                            <h6 class="mt-4 mb-3">المنتجات</h6>
                            @foreach ($order->items as $item)
                                <div class="order-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            @if ($item->product && $item->product->images()->first())
                                                <img src="{{ asset($item->product->images()->first()->image_url) }}"
                                                    alt="{{ $item->product->name }}" class="product-img">
                                            @else
                                                <img src="{{ asset('assets/images/img1.png') }}" alt="صورة افتراضية"
                                                    class="product-img">
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{ $item->product ? $item->product->name : 'منتج غير متوفر' }}</h6>
                                            <p class="mb-0">البائع: {{ $item->product->user->name ?? 'غير معروف' }}</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <p class="mb-0">الكمية: {{ $item->quantity }}</p>
                                            <p class="mb-0">السعر: {{ $item->price }} ريال</p>
                                            <p class="mb-0"><strong>المجموع: {{ $item->price * $item->quantity }}
                                                    ريال</strong></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
