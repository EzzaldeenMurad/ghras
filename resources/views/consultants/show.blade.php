@extends('layouts.master-with-header')

@section('title', 'المستشارين')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/consultants.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Main Content Area -->

            <div class="col-lg-3">
                <!-- Consultant Profile -->
                <div class="consultant-card">
                    <div class="row flex-column gap-4">
                        <div class="col-md-7 consultant-img  w-100">
                            <img src="{{ $consultant->image ? asset($consultant->image) : asset('assets/images/consultant.png') }}" alt="المستشار ماهر سعيد">
                        </div>
                        <div class="col-md-5 text-center w-100">
                            <h1 class="consultant-name">المستشار<br>{{ $consultant->name ?? 'غير معروف' }}</h1>
                            <p class="consultant-specialty">{{ $consultant->specialty ?? 'علوم الحيوانات' }} </p>
                            <button class="btn btn-primary">طلب استشارة</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <!-- Certificates Section -->
                <h2 class="certificate-title mb-4">شهادات المستشار</h2>
                <div class="row ms-1">
                    <div class="col-md-4">
                        <div class="certificate-card"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="certificate-card"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="certificate-card"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
