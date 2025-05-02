@extends('layouts.master')

@section('title', 'انشاء حساب')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
    <div class="register-page">
        <div class="text-center mb-4">
            <div class="mb-3">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="غراس" class="logo img-fluid" />
                </a>
            </div>
        </div>

        <h2 class="tiltle-auth text-center mb-5">إنشاء حساب</h2>
        <p class="sub-title text-center mb-4">سيتم ارسال رسالة للتحقق من البريد الالكتروني المضاف ..</p>

        <form class="auth-content" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="lastName" class="form-label">الاسم  <span class="text-danger">*</span></label>
                <input type="text" id="lastName" name="name" class="form-control input-field px-3 py-2"
                       placeholder="مثال.. علي" value="{{ old('name') }}" />
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div class="mb-3">
                <label for="accountType" class="form-label">نوع الحساب <span class="text-danger">*</span></label>
                <select id="accountType" name="account_type" class="form-control input-field px-3 py-2">
                    <option value="seller" {{ old('account_type') == 'seller' ? 'selected' : '' }}>تاجر</option>
                    <option value="buyer" {{ old('account_type') == 'buyer' ? 'selected' : '' }}>زبون</option>
                    <option value="consultant" {{ old('account_type') == 'consultant' ? 'selected' : '' }}>مستشار</option>
                </select>
                <x-input-error :messages="$errors->get('account_type')" />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">البريد الالكتروني <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control input-field px-3 py-2"
                    placeholder="user@demo.com" value="{{ old('email') }}" />
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">كلمة السر <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" class="form-control input-field px-3 py-2" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="pt-2 text-center">
                <button type="submit" name="register_submit" class="btn auth-btn m-auto">حساب جديد</button>
            </div>
        </form>
    </div>
@endsection
