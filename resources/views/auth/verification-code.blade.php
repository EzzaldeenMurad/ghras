@extends('layouts.master')

@section('title', 'التحقق من الحساب')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
    <div class="verification-page">
        <div class="text-center mb-4">
            <div class="mb-3">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="غراس" class="logo img-fluid" />
                </a>
            </div>
        </div>

        <h2 class="tiltle-auth text-center mb-5">رمز التحقق</h2>
        <p class="sub-title text-center mb-4">أدخل الرمز المرسل إليك عبر البريد الالكتروني أو الواتساب</p>

        <form class="auth-content" action="{{ route('verification.verify') }}" method="POST">
            @csrf
            <div class="d-flex flex-column gap-4">
                <p class="tiltle-verification"> ادخل الرمز</p>
                <div class="verification-code-input mb-5">
                    <input type="text" name="code[]" maxlength="1" value="{{ old('code.0', '0') }}">
                    <input type="text" name="code[]" maxlength="1" value="{{ old('code.1', '0') }}">
                    <input type="text" name="code[]" maxlength="1" value="{{ old('code.2', '0') }}">
                    <input type="text" name="code[]" maxlength="1" value="{{ old('code.3', '0') }}">
                    <input type="text" name="code[]" maxlength="1" value="{{ old('code.4', '0') }}">
                </div>
                <x-input-error :messages="$errors->get('code')" class="text-center" />
            </div>
            <div class="pt-2 text-center">
                <button type="submit" name="verify_submit" class="btn auth-btn m-auto">تاكيد الرمز</button>
            </div>
        </form>
    </div>
@endsection
