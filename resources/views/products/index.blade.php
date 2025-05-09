@extends('layouts.master-with-header')

@section('title', 'المنتجات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
    <style>
        /* إخفاء شكل الـ scrollbar مع إبقاء التمرير */
        .category-swiper .swiper-scrollbar {
            display: none !important;
        }

        .category-swiper::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }

        .category-swiper {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE 10+ */
        }

        .swiper-slide {
            height: auto !important;
        }

        a {
            color: #000;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="sidebar-title border-0 pt-0">القائمة الرئيسية</div>

                <div class="mb-4">
                    <div class="sidebar-title border-0 pt-0">العروض</div>
                </div>
                <!-- Categories Filter -->
                <div class="filter-box">
                    <!-- Swiper Container -->
                    <div class="swiper category-swiper" style="min-height:370px; max-height:450px; overflow: hidden;">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <form id="categoryFilterForm" action="{{ route('products.index') }}" method="GET">
                                    @if (request()->has('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif

                                    @foreach ($categories as $category)
                                        <div class="mb-3">
                                            <div class="filter-item">
                                                <div class="sidebar-title">{{ $category->name }}</div>
                                            </div>

                                            @if (count($category->children) > 0)
                                                <div style="padding-right: 15px;">
                                                    @foreach ($category->children as $child)
                                                        <div class="filter-item">
                                                            <input type="radio" id="child_{{ $child->id }}"
                                                                name="child_id" value="{{ $child->id }}"
                                                                {{ request('child_id') == $child->id ? 'checked' : '' }}
                                                                onchange="document.getElementById('categoryFilterForm').submit()">
                                                            <label
                                                                for="child_{{ $child->id }}">{{ $child->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </form>
                            </div>
                        </div>
                        <!-- Scrollbar -->
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>المنتجات
                        @if (request('search'))
                            - نتائج البحث عن "{{ request('search') }}"
                        @elseif(request('category_id'))
                            - {{ $categories->where('id', request('category_id'))->first()->name ?? '' }}
                        @endif
                    </h4>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <!-- Products -->
                    @forelse ($products as $product)
                        <div class="col-md-4">
                            <a href="{{ route('products.show', $product->id) }}" class="product-card ">
                                <div class="product-img">
                                    <img src="{{ $product->images() ? asset($product->images()->first()->image_url ?? 'assets/images/img1.png') : asset('assets/images/img1.png') }}"
                                        alt="{{ $product->name }}">
                                </div>
                                <div class="text-center p-3">
                                    <h5 class="product-title">{{ $product->name }}</h5>
                                    <p class="product-desc">{!! Str::limit($product->description, 50) !!}</p>
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <div class="rating  border-black ps-2">{{-- border-start --}}
                                            <i class="fas fa-star"></i>
                                            <span class="ms-1 rating-text">{{ $product->rate() }}/5</span>
                                        </div>
                                        <!-- comments -->
                                        {{-- <div class="comments pe-3">
                                            <span class="comment-icon"><i class="fas fa-comment"></i></span>
                                            <span class="comment-count">3</span>
                                        </div> --}}
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span>{{ $product->price }} ريال</span>
                                    </div>
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                @if (Cart::instance()->content()->where('id', $product->id)->count() > 0)
                                    <button type="button" class="add-to-cart" disabled>أضف إلى السلة</button>
                                @else
                                    <button type="submit" class="add-to-cart">اضافة للسلة</button>
                                @endif
                            </form>
                        </div>

                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center w-100">
                        لا توجد منتجات لعرضها.
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            {{-- <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div> --}}
        </div>
    </div>
    </div>
@endsection

@section('scripts')

    <script>
        new Swiper('.category-swiper', {
            direction: 'vertical',
            slidesPerView: 'auto',
            freeMode: true,
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },
            mousewheel: true,
        });
    </script>

@endsection
