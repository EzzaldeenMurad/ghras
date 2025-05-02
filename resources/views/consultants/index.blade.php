@extends('layouts.master-with-header')

@section('title', 'المستشارين')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/consultants.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Consultants Content -->

            <div class="col-lg-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <!-- Product 1 -->
                    @forelse ($consultants as $consultant)
                        <div class="col">
                            <div class="product-card">
                                <img src=" {{ $consultant->image ?asset($consultant->image) : asset('assets/images/avatar_user.jpg') }}"
                                    class="product-img" alt="مستشار" title="مستشار">
                                <div class="text-center p-3">
                                    <h5 class="product-title">{{ $consultant->name }}</h5>
                                    <p class="product-desc">{{ $consultant->description }}</p>

                                    <a href="{{ route('consultants.show', $consultant->id) }}"
                                        class="btn btn-primary more-btn rounded">تفاصيل</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center">
                                <div class="alert alert-warning text-center">
                                    لا يوجد مستشارين لعرضهم.
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

@endsection
