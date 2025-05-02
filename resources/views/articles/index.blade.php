@extends('layouts.master-with-header')

@section('title', 'المقالات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/articles.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Articles Grid -->
            <div class="col-12">
                <div class="articles-container  rounded p-4">
                    <div class="row g-4">
                        <!-- Article Card -->
                        @forelse ($articles as $article)
                            <div class="col-md-4">
                                <div class="article-card">
                                    <img src="{{ asset($article->image_url) ?? asset('assets/images/img1.png') }}"
                                        class="card-img-top" alt="مقال عن النخيل">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $article->title }}</h5>
                                        <p class="card-text">{{ $article->content }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                {{ $article->created_at->locale('ar')->translatedFormat('F Y') }}
                                            </small>
                                            <a href="{{ route('articles.show', $article->id) }}"
                                                class="btn btn-primary btn-sm">اقرأ
                                                المزيد</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    لا توجد مقالات لعرضها.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
