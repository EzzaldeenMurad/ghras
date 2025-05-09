@extends('layouts.master-with-header')

@section('title', 'تفاصيل المنتج')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashbord.css') }}">

    <style>
        .product-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .product-thumbnail.active {
            border-color: #d2691e;
        }

        .product-info {
            background-color: transparent !important;
            box-shadow: 0px 2.71px 12.21px 0px #4B465C1A;

            border-radius: 8px;
            padding: 20px;
        }

        .product-info h1 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .product-price {
            font-size: 1.5rem;
            color: #d2691e;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-description {
            margin-top: 20px;
            line-height: 1.6;
        }

        .card {
            background-color: transparent !important;
            box-shadow: 0px 2.71px 12.21px 0px #4B465C1A !important;
            border: none;

        }

        .seller-info {
            background-color: transparent !important;
            box-shadow: 0px 2.71px 12.21px 0px #4B465C1A;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .btn-primary {
            min-height: 39px !important;

        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('dashboard.partials.sidebar')
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">تفاصيل المنتج</h5>
                        <a href="{{ route('seller.products') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-right ml-1"></i> العودة للمنتجات
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="product-gallery">
                                <div class="main-image mb-3">
                                    <img src="{{ asset($product->images()->first() ? asset($product->images()->first()->image_url) : asset('assets/images/img1.png')) }}"
                                        alt="{{ $product->name }}" class="product-image" id="main-product-image">
                                </div>

                                @if ($product->images->count() > 1)
                                    <div class="thumbnails d-flex flex-wrap gap-2">
                                        @foreach ($product->images as $image)
                                            <img src="{{ asset($image ? asset($image->image_url) : asset('assets/images/img1.png')) }}"
                                                class="product-thumbnail {{ $image->id === $product->images()->first()->id ? 'active' : '' }}"
                                                data-src="{{ asset($image->image_url) }}" onclick="changeMainImage(this)">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="product-info">
                                <h1>{{ $product->name }}</h1>

                                <div class="product-meta">
                                    <span>الفئة: {{ $product->category->name ?? 'بدون فئة' }}</span>
                                    <span>تاريخ الإضافة: {{ $product->created_at->format('Y-m-d') }}</span>
                                </div>

                                <div class="product-price">
                                    {{ $product->price }} ريال
                                </div>

                                <div class="product-description">
                                    <h5>وصف المنتج:</h5>
                                    <p>{!! $product->description ?? 'لا يوجد وصف متاح' !!}</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('seller.products.edit', $product) }}"
                                        class="btn btn-primary mx-2 fs-5">
                                        <i class="fas fa-edit"></i>
                                        تعديل المنتج</a>
                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                            <i class="fas fa-trash-alt"></i> حذف المنتج
                                        </button>
                                    </form>
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
    <script>
        function changeMainImage(element) {
            // Update main image
            document.getElementById('main-product-image').src = element.dataset.src;

            // Update active state
            document.querySelectorAll('.product-thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            element.classList.add('active');
        }
    </script>
@endsection
