@extends('layouts.master')

@section('title', 'تسجيل دخول')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
    <div class="login-page">
        <div class="text-center mb-4">
            <div class="mb-3">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="غراس" class="logo img-fluid" />
                </a>
            </div>
        </div>

        <h2 class="tiltle-auth text-center mb-5">تسجيل دخول</h2>
        <p class="sub-title text-center mb-4">قم بإدخال البريد الالكتروني وكلمة السر الخاصة بك</p>

        <form class="auth-content" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">البريد الالكتروني</label>
                <input type="email" id="email" name="email" class="form-control input-field px-3 py-2"
                    placeholder="user@demo.com" value="{{ old('email') }}" />
                <small class="text-muted mt-1 d-block">البريد الالكتروني الخاص بالمستخدم</small>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">كلمة السر</label>
                <input type="password" id="password" name="password" class="form-control input-field px-3 py-2" />
                <small class="text-muted mt-1 d-block">كلمة السر الخاصة بالبريد الالكتروني</small>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="pt-2 text-center">
                <button type="submit" name="login_submit" class="btn auth-btn m-auto">تسجيل دخول</button>
            </div>

            <div class="text-center pt-3">
                <a href="{{ route('password.request') }}" class="d-block text-muted text-decoration-none mb-2">نسيت كلمة السر</a>
                <a href="{{ route('register') }}" class="d-block text-muted text-decoration-none">إنشاء حساب</a>
            </div>
        </form>
    </div>
@endsection
