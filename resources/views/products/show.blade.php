@extends('layouts.master-with-header')

@section('title', 'المنتجات')

@section('css')
    <style>
        .thumbnail-img {
            border-radius: 8px;
            height: 60px;
            width: 60px;
            /* cursor: pointer; */
        }

        .thumbnail-img img {
            width: 100%;
            border-radius: 8px;
            height: 100%;
        }

        .product-image {
            height: 231px;
            width: 275px;
            border-radius: 12px;
        }

        .product-image img {
            height: 100%;
            width: 100%;
            border-radius: 12px;
        }

        .highlight {
            color: #d47b22;
        }

        /* .profileimage{
                                                                                                height: 400px;
                                                                                                 width: 400px;
                                                                                            } */
        .profileimage {
            width: 120px;
            height: 120px;
            margin: auto;
        }

        .name-farmer {
            font-size: 11px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        {{-- {{$product->user}} --}}
        <div class="row">

            <!-- Right Sidebar -->
            <div class="col-md-3 sidebar text-center">
                <h5 class="mb-3">بيانات المزارع</h5>
                <div class="profileimage">
                    <img src="{{ $product->user->image ? asset($product->user->image) : asset('assets/images/avatar_user.jpg') }}"
                        class="rounded-circle mb-2 w-100 h-100" alt="Farmer">
                </div>
                <p class="name-farmer">اسم المزارع</p>
                <p class="fw-bold">{{ $product->user->name }}</p>
            </div>

            <!-- Left Main Content -->
            <div class="col-md-9">
                <h3 class="mb-4 fw-bold">تفاصيل المنتج / {{ $product->name }}</h3>
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-md-5">
                        <!-- Product Image Carousel -->
                        <div class="product-image mb-3">
                            <img src="{{ asset($product->images()->first()->image_url) }}" id="mainImage"
                                alt="Sukkari Dates">
                        </div>

                        <!-- Thumbnails -->
                        <div class="d-flex justify-content-start gap-2 mb-4">
                            @foreach ($product->images as $image)
                                <div class="thumbnail-img">
                                    <img src="{{ asset($image->image_url) }}" class="border"
                                        onclick="changeImage(this.src)">
                                </div>
                            @endforeach
                            {{-- <div class="thumbnail-img">
                                    <img src="{{ asset('storage/' . $product->images()->first()->image_url ?? 'assets/images/img1.png') }}"
                                        class=" border" onclick="changeImage(this.src)">
                                </div> --}}
                        </div>
                    </div>
                    <!-- Product Details -->
                    <div class=" col-md-7 px-2">
                        <p><strong>الاسم:</strong> {{ $product->name }}</p>
                        <p> {!! $product->description !!}</p>
                        <!-- Review -->
                        <div class="d-flex justify-content-center">

                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-12"> <span>تقيم المنتج</span></div>
                                <div class="col-12"> <span class="text-warning fs-5">★ ★</span></div>
                            </div>
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-12"> <span>تم شراؤه </span></div>
                                <div class="col-12"> <span>102 مرة</span></div>
                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
