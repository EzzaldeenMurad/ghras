@extends('layouts.master')

@section('title', 'طلب استشارة')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endsection

@section('content')
    <div class="login-page ">
        <div class="text-center">
            <div class="my-3 mx-auto" style="width: 150px; height: 150px">
                <img src="{{ $consultant->image ? asset($consultant->image) : asset('assets/images/consultant.png') }}"
                    alt="غراس" class="logo img-fluid rounded-circle h-100 w-100" />
            </div>
        </div>

        <h4 class="tiltle-auth text-center mb-2">{{ $consultant->name }}</h4>


        <form class="auth-content" action="{{ route('consultants.consultation.store') }}" method="POST">
            @csrf

            <input type="hidden" name="consultation_id" value="{{ $consultant->consultation->id }}">
            <div class="mb-3">
                <label for="subject" class="form-label">الموضوع</label>
                <input type="subject" id="subject" name="subject" class="form-control input-field px-3 py-2"
                    placeholder="اكتب الموضوع" value="{{ old('subject') }}" />
                {{-- <small class="text-muted mt-1 d-block"> </small> --}}
                <x-input-error :messages="$errors->get('subject')" />
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">التفاصيل</label>
                <textarea name="description" class="form-control input-field px-3 py-2" id="description" cols="30" rows="3"></textarea>
                {{-- <small class="text-muted mt-1 d-block">  الخاصة بالبريد الالكتروني</small> --}}
                <x-input-error :messages="$errors->get('description')" />
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">سعر الاستشاره</label>
                <input type="price" id="price" name="price" readonly class="form-control input-field px-3 py-2"
                    value="{{ $consultant->consultation->price ?? '' }}" />
                {{-- <small class="text-muted mt-1 d-block">  الخاصة بالبريد الالكتروني</small> --}}
                <x-input-error :messages="$errors->get('price')" />
            </div>

            <div class="pt-2 text-center">
                <button type="submit" name="login_submit" class="btn auth-btn m-auto">طلب الاستشارة</button>
            </div>

            <div class="text-center pt-3">
                <a href="{{ route('consultants.show', $consultant->id) }}"
                    class="d-block text-muted text-decoration-none">الرجوع الى الخلف</a>
            </div>
        </form>
    </div>
@endsection
