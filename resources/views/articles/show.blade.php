@extends('layouts.master-with-header')

@section('title', 'المقالة | ')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/articles.css') }}">
    <style>
        .swiper-container .swiper-scrollbar {
            display: none !important;
        }

        .swiper-container::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }

        .swiper-container{
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE 10+ */
        }

        .swiper-container {
            max-height: 320px !important;
            overflow: hidden;
            max-width: 220px !important;
        }

        .star-container .stars-inactive {
            position: absolute;
            top: 0px;
            left: 4px;
        }

        .star-container {
            /* background-color: var(--secondary-color);
                                    color: var(--main-color);
                                    border-radius: var(--main-radius); */
            width: 50%;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div id="article">
            <div class="row">
                <div class="col-md-4 mb-4 product-image">
                    <img src="{{ $article->image_url ? asset($article->image_url) : asset('assets/images/img1.png') }}"
                        alt="صورة تمور">
                </div>
                <div class="col-md-8 ">
                    <div class="article-details-card ">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h4>{{ $article->title }}</h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>قسم المنتجات </h4>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>{{ $article->user->name }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ $article->created_at->locale('ar')->translatedFormat('l d-m-Y') }}</h5>

                                </div>

                            </div>

                            <div class="row ">
                                <div class="col-12">
                                    <p class="centered-text">
                                        {{ $article->content }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="mb-3" style="border-right: 4px solid #8B5E3C; padding-right: 10px;">اراء العملاء </h5>

            <div class="row ">

                <div class="col-5">
                    <div class="swiper-container" style=" overflow: hidden;">
                        <div class="swiper-wrapper">
                            @forelse ($article->reviews as $review)
                                <div class="swiper-slide">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div
                                                style="width: 40px; height: 40px; background-color: #ddd; border-radius: 50%; overflow: hidden; margin-left: 10px;">
                                                <img src="{{ asset($review->user->image) ?? asset('assets/images/consultant.png') }}"
                                                    alt="صورة شخصية"
                                                    class="bi bi-person-fill d-flex justify-content-center align-items-center h-100"
                                                    style="font-size: 1.5rem;"></img>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $review->user->name }}</h6>
                                                <small class="text-muted">{{ $article->user->region }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <span>{{ $review->review }} {{ $review->rate }}</span>
                                    </div>
                                    <div class="star-container   position-relative">
                                        <span class="stars-active" style="width:{{ $review->rate * 20 }}%">
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
                                    {{-- <div class="mb-3">
                                        <p>{{ $review->review }}</p>
                                        <div class="rating" id="rating-">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span data-value="{{ $i }}" class="rating-star ">★</span>
                                            @endfor
                                        </div>
                                    </div> --}}
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="col-12">
                                        <div class="alert alert-warning text-center">
                                            لا توجد تعليقات لعرضها.
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <!-- Add scrollbar -->
                        <div class="swiper-scrollbar"></div>
                    </div>
                    <div class="mt-4" id="review-div">
                        <form action="{{ route('articles.review.store') }}" method="post"
                            class="input-group comment-form ">
                            @csrf
                            <div class="input-group d-flex gap-3">
                                <input type="text" class="form-control" placeholder="اضافة تعليق جديد" name="review"
                                    required>
                                <button type="submit" class="btn btn-primary">إرسال</button>
                            </div>
                            <div>
                                @for ($i = 1; $i <= 5; $i++)
                                    <span data-value="{{ $i }}" class="rating-star"
                                        onclick="rateProduct({{ $i }})" id="star-{{ $i }}">★</span>
                                @endfor
                                <input type="hidden" name="rating" class="rating-input" id="ratingInput">
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                            </div>
                            @error('rating')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror


                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('alerts.alert')
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script>
        function rateProduct(value) {
            // تخزين القيمة في الحقل المخفي
            document.getElementById('ratingInput').value = value;

            // تحديث لون النجوم
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + i);
                if (i <= value) {
                    star.classList.add('checked');
                } else {
                    star.classList.remove('checked');
                }
            }
        }
    </script>

    <script>
        const swiper = new Swiper('.swiper-container', {
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
    {{-- <script>
        const value = parseInt(star.getAttribute('data-value'));
        const ratingInput = document.getElementById('ratingInput');
        if (value) {
            ratingInput.value = value;
        }
    </script> --}}
    {{-- <script>
        function rateArticle(articleId, ratingValue) {
            fetch(`/rate-article`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        article_id: articleId,
                        value: ratingValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStars(articleId, ratingValue);
                    } else {
                        alert(data.message || "حدث خطأ.");
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateStars(articleId, ratingValue) {
            const container = document.getElementById(`rating-${articleId}`);
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
    </script> --}}

@endsection
