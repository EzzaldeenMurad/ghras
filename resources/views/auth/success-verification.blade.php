@extends('layouts.master')

@section('title', 'نجاح التحقق')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
    <div class="success-verification-page">
        <div class="text-center mb-4">
            <div class="mb-3">
                <a href="index.html">
                    <img src="../assets/images/logo.png" alt="غراس" class="logo img-fluid" />
                </a>
            </div>
        </div>

        <h2 class="tiltle-auth text-center mb-5">لقد تم التحقق بنجاح</h2>
        <p class="sub-title text-center mb-4">سيتم العوده الى الصفحة الرئيسية</p>

        <div class="pt-2 text-center">
            <a href="index.html" type="button" class="btn auth-btn m-auto">الصفحة الرئيسية</a>
        </div>
    </div>
@endsection
