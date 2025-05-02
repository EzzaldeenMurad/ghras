@extends('layouts.master')

@section('title', 'اعادة تعين كلمة السر')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
    <div class="reset-page">
        <div class="text-center mb-4">
            <div class="mb-3">
              <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="غراس" class="logo img-fluid" />
              </a>
            </div>
          </div>

          <h2 class="tiltle-auth text-center mb-5">اعادة تعين كلمة السر</h2>
          <p class="sub-title text-center mb-4">الرجاء حفظ كلمة السر الخاصه بك عند تسجيل الدخول</p>

          <form class="auth-content" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token ?? '' }}">
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
            
            <div class="mb-3">
              <label for="password" class="form-label">كلمة السر الجديدة<span class="text-danger">*</span></label>
              <input type="password" id="password" name="password" class="form-control input-field px-3 py-2" />
              <x-input-error :messages="$errors->get('password')" />
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label"> تاكيد كلمة السر الجديدة<span
                  class="text-danger">*</span></label>
              <input type="password" id="confirmPassword" name="password_confirmation" class="form-control input-field px-3 py-2" />
              <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>
            <div class="pt-2 text-center">
              <button type="submit" name="password_reset_submit" class="btn auth-btn m-auto">حفظ كلمة السر</button>
            </div>
          </form>
    </div>
@endsection
