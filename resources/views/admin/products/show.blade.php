@extends('layouts.master-with-header')

@section('title', 'تفاصيل المنتج')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
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
            background-color: #f8f9fa;
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

        .seller-info {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
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
                        <h5 class="card-title">تفاصيل المنتج</h5>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-right ml-1"></i> العودة للمنتجات
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="product-gallery">
                                <div class="main-image mb-3">
                                    @if ($product->images->count() > 0)
                                        <img src="{{ asset($product->images()->first()->image_url) }}"
                                            alt="{{ $product->name }}" class="product-image" id="main-product-image">
                                    @else
                                        <div
                                            class="product-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>

                                @if ($product->images->count() > 1)
                                    <div class="thumbnails d-flex flex-wrap gap-2">
                                        @foreach ($product->images as $image)
                                            <img src="{{ asset($image->image_url) }}" alt="{{ $product->name }}"
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
                                <div class="seller-info">
                                    <h5>معلومات البائع:</h5>
                                    <p><strong>الاسم:</strong> {{ $product->user->name ?? 'غير معروف' }}</p>
                                    <p><strong>البريد الإلكتروني:</strong> {{ $product->user->email ?? 'غير متاح' }}
                                    </p>
                                    <p><strong>تاريخ التسجيل:</strong>
                                        {{ $product->user->created_at->format('Y-m-d') ?? 'غير متاح' }}</p>
                                </div>

                                <div class="mt-4">
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
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
