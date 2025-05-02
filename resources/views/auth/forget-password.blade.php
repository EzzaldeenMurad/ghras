@extends('layouts.master')

@section('title', 'نسيت كلمة السر')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
    <div class="forget-page">
        <div class="text-center mb-4">
            <div class="mb-3">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="غراس" class="logo img-fluid" />
                </a>
            </div>
        </div>

        <h2 class="tiltle-auth text-center mb-5">نسيان كلمة السر</h2>
        <p class="sub-title text-center mb-4">أدخل بريدك الالكتروني وسنقوم بارسال التعليمات لك</p>

        <form class="auth-content" action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">البريد الالكتروني <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control input-field px-3 py-2"
                    placeholder="user@demo.com" value="{{ old('email') }}" />
                <small class="text-muted mt-1 d-block">البريد الالكتروني الخاص بالمستخدم</small>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="pt-2 text-center">
                <button type="submit" name="reset_submit" class="btn auth-btn m-auto">أرسال رابط اعادة تعين كلمة السر</button>
            </div>
        </form>
    </div>
@endsection
