@extends('layouts.master-with-header')

@section('title', 'المنتجات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="contact-container shadow rounded p-4">
                    <h4 class="text-center mb-4">تواصل معنا</h4>
                    <div class="contact-info mt-5 text-center">
                        <h5 class="text-center mb-4">معلومات التواصل</h5>
                        <div class="row text-center">
                            <div class="col-md-6">
                                <i class="fas fa-phone mb-2"></i>
                                <p>55 555 5555 966+</p>
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-envelope mb-2"></i>
                                <p>ghras.support@gmail.com</p>
                            </div>
                        </div>
                        <h5 class="text-center my-4">موقعنا عبر الخريطة</h5>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3452.593593593593!2d46.7418413150624!3d24.774595983027363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f033f0a4b7b4b%3A0x9b9b9b9b9b9b9b9b!2sGhras%20Project!5e0!3m2!1sar!2seg!4v1689654636789!5m2!1sar!2seg"
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
