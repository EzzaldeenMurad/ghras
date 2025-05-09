@extends('layouts.master-with-header')

@section('title', 'الصفحة الرئيسية ')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <style>
        .stars-inactive {
            color: var(--dark-beige) !important;
            position: absolute;
            top: 8px;
            left: 8px;
        }

        .stars-active {
            color: #FFCA00;
            position: relative;
            z-index: 10;
            display: block;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
@endsection

@section('content')
    <div class="container"> <!-- Hero Section -->
        <div class="container hero text-center text-lg-end py-4">
            <div class="row align-items-center h-100 text-lg-center">
                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                    <h3 class="fw-bold">أجود أنواع التمور من مزارعنا إلى منزلك</h3>
                </div>
                <div class="col-12 col-lg-6">
                    <h3 class="fw-bold">تمور طازجة ومغذية بأسعار تنافسية</h3>
                </div>
            </div>
        </div>
        <!-- Product Section -->
        <div class="container my-5 product-section">
            <div class="row">
                <h2 class="mb-4">منتجات الأكثر تقييم</h2>
                <!-- Product Card -->
                @forelse ($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="col-md-3">
                        <div class="card product-card position-relative">
                            <img src="{{ asset($product->images()->first() ? asset($product->images()->first()->image_url) : asset('assets/images/img1.png')) }}"
                                class="card-img-top product-img" alt="تمر برجي">
                            <div class="card-body position-absolute bottom-0 start-50 translate-middle py-1 px-2 w-100">
                                <h5 class="card-title ">{{ $product->name }}</h5>
                            </div>
                            <div class="star-container  position-absolute position-relative p-2">
                                <span class="stars-active" style="width:{{ $product->rate() * 20 }}%">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>

                                <span class="stars-inactive">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            لا توجد منتجات لعرضها.
                        </div>
                    </div>
                @endforelse

            </div>
        </div>

    </div>
@endsection
