@extends('layouts.master-with-header')

@section('title', 'المنتجات | لوحة التحكم')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashbord.css') }}">

    <style>
        .product-img {
            /* box-shadow: 0px 4px 4px 0px #00000040 inset; */
            width: 245px;
            height: 165px;
        }

        .product-img img {
            border-radius: var(--main-radius);
            width: 100%;
            height: 100%;
        }

        .product-name {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid my-5 ">
        <div class="row">
            <!-- Sidebar -->
            @include('dashboard.partials.sidebar')

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="card bg-transparent border-0" style="width: 97%;">
                    <div class="card-body">
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <a href="{{ route('seller.products.create') }}" class="btn btn-primary btn-sm">
                                إضافة منتج
                            </a>
                        </div>


                        <div class="row">

                            @forelse ($products as $product)
                                <div class="col-12 col-md-4 mb-4">
                                    <div class="d-flex flex-column card-product  gap-1">
                                        <div class="product-img d-flex align-items-center justify-content-center">
                                            <img src="{{ asset( $product->images()->first()->image_url) }}"
                                                alt="منتج" class="img-fluid ">
                                        </div>
                                        <p class="product-name">{{ $product->name }}</p>
                                    </div>
                                </div>
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
            </div>
        </div>
    </div>
@endsection
