@extends('layouts.master-with-header')

@section('title', 'المقالة | ')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/articles.css') }}">
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
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <div
                                style="width: 40px; height: 40px; background-color: #ddd; border-radius: 50%; overflow: hidden; margin-left: 10px;">
                                <img src="{{ asset('assets/images/consultant.png') }}" alt="صورة شخصية"
                                    class="bi bi-person-fill d-flex justify-content-center align-items-center h-100"
                                    style="font-size: 1.5rem;"></img>
                            </div>
                            <div>
                                <h6 class="mb-0">محمد يوسف</h6>
                                <small class="text-muted">الخرمة</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p>أفضل منتج في السوق العربي</p>
                        <div>
                            <span class="circle-rating active"></span>
                            <span class="circle-rating active"></span>
                            <span class="circle-rating active"></span>
                            <span class="circle-rating active"></span>
                            <span class="circle-rating"></span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form action="#" method="post" class="input-group comment-form">
                            <input type="text" class="form-control" placeholder="اضافة تعليق جديد">
                            <button class="btn btn-primary">إرسال</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
