@extends('layouts.master-with-header')

@section('title', 'تم إتمام الطلب بنجاح')

@section('css')
    <style>
        .order-success {
            text-align: center;
            padding: 50px 0;
        }
        
        .order-success i {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        
        .order-details {
            margin-top: 40px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .order-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
    </style>
@endsection

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="order-success">
                <i class="fas fa-check-circle"></i>
                <h2>تم إتمام الطلب بنجاح</h2>
                <p>شكراً لك على طلبك. رقم الطلب الخاص بك هو: <strong>#{{ $order->id }}</strong></p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="order-details">
                <h4>تفاصيل الطلب</h4>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5>معلومات الشحن</h5>
                        <p><strong>الاسم:</strong> {{ $order->name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $order->email }}</p>
                        <p><strong>الهاتف:</strong> {{ $order->phone }}</p>
                        <p><strong>العنوان:</strong> {{ $order->address }}</p>
                        <p><strong>المدينة:</strong> {{ $order->city }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>معلومات الطلب</h5>
                        <p><strong>رقم الطلب:</strong> #{{ $order->id }}</p>
                        <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
                        <p><strong>حالة الطلب:</strong> {{ $order->status }}</p>
                        <p><strong>طريقة الدفع:</strong> بطاقة ائتمان</p>
                        <p><strong>المجموع:</strong> {{ $order->total }} ريال</p>
                    </div>
                </div>
                
                <h5 class="mt-4">المنتجات</h5>
                @foreach($order->items as $item)
                <div class="order-item">
                    <div class="row">
                        <div class="col-md-2">
                            @if($item->product && $item->product->images->first())
                            <img src="{{ asset($item->product->images->first()->image_url) }}" alt="{{ $item->product->name }}" class="img-fluid">
                            @else
                            <div class="placeholder-image">No Image</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>{{ $item->product ? $item->product->name : 'منتج غير متوفر' }}</h6>
                            <p>الكمية: {{ $item->quantity }}</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <p>{{ $item->price }} ريال</p>
                            <p><strong>المجموع: {{ $item->price * $item->quantity }} ريال</strong></p>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary">العودة إلى الصفحة الرئيسية</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection