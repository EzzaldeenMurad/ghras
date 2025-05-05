@extends('layouts.master-with-header')

@section('title', 'المنتجات')

@section('css')
    <style>
        .thumbnail-img {
            border-radius: 8px;
            height: 60px;
            width: 60px;
            cursor: pointer;
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

        .profileimage {
            width: 120px;
            height: 120px;
            margin: auto;
        }

        .name-farmer {
            font-size: 11px;
        }



        .star-container .stars-inactive {
            position: absolute;
            top: 0px;
        }

        .star-container {
            background-color: var(--secondary-color);
            color: var(--main-color);
            border-radius: var(--main-radius);
            width: 60%;
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
                                        onclick="changeMainImage(this)">
                                </div>
                            @endforeach
                            {{-- <div class="thumbnail-img">
                                    <img src="{{ asset('storage/' . $product->images()->first()->image_url ?? 'assets/images/img1.png') }}"
                                        class=" border" onclick="changeImage(this.src)">
                                </div> --}}
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <p>قيم هذا المنتج</p>

                            <div class="rating" id="rating-{{ $product->id }}">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span data-value="{{ $i }}"
                                        onclick="rateProduct({{ $product->id }}, {{ $i }})"
                                        class="rating-star ">★</span>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <!-- Product Details -->
                    <div class=" col-md-7 px-2">
                        <p><strong>الاسم:</strong> {{ $product->name }}</p>
                        <p> {!! $product->description !!}</p>

                        <div class="d-flex justify-content-center">

                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-12"> <span>تقيم المنتج</span></div>
                                <div class="col-12">
                                    <div class="star-container   position-relative">
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
@section('scripts')
    <script>
        function changeMainImage(imageElement) {
            // Get the main image element
            const mainImage = document.getElementById('mainImage');
            // Set its src to the clicked sub-image's src
            mainImage.src = imageElement.src;
        }
    </script>

    <script>
        function rateProduct(productId, ratingValue) {
            fetch(`/rate-product`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        value: ratingValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStars(productId, ratingValue);
                        updateRatingDisplay(productId, data.averageRating);
                    } else {
                        alert(data.message || "حدث خطأ.");
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        function updateStars(productId, ratingValue) {
            const container = document.getElementById(`rating-${productId}`);
            const stars = container.querySelectorAll('.rating-star');
            stars.forEach(star => {
                const value = parseInt(star.getAttribute('data-value'));
                if (value <= ratingValue) {
                    star.classList.add('checked');
                } else {
                    star.classList.remove('checked');
                }
            });
        }

        function updateRatingDisplay(productId, averageRating) {
            const container = document.querySelector('.star-container .stars-active');
            // alert(newRating);
            if (container) {

                container.style.width = `${averageRating * 20}%`;
            }
        }
    </script>
@endsection
