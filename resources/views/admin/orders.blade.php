@extends('layouts.master-with-header')

@section('title', 'لوحة التحكم| إدارة الطلبات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.admin-sidebar')
        <!-- Main Content -->
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">إدارة الطلبات</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>تاريخ الطلب</th>
                                    <th>البائع</th>
                                    <th>المشتري</th>
                                    <th>المبلغ</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($item->product && $item->product->images->count() > 0)
                                                        <img src="{{ asset($item->product->images->first()->image_url) }}"
                                                            alt="{{ $item->product->name }}" class="product-img">
                                                    @else
                                                        <div
                                                            class="product-img bg-light d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <span>{{ $item->product ? $item->product->name : 'منتج محذوف' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>{{ $item->product && $item->product->user ? $item->product->user->name : 'غير متوفر' }}
                                            </td>
                                            <td>{{ $order->user ? $order->user->name : $order->name }}</td>
                                            <td>{{ number_format($item->price * $item->quantity, 2) }} ريال</td>

                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا توجد طلبات</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
