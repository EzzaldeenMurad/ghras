@extends('layouts.master-with-header')

@section('title', ' سجل المشتريات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashbord.css') }}">
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('dashboard.partials.sidebar')
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card bg-transparent border-0" style="width: 97%;">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <h5 class="card-title text-center">طلبات الإستشارة</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>الموضوع</th>
                                    <th>تاريخ</th>
                                    <th>أسم المستخدم</th>
                                    <th>السعر</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        حماية الاشجار
                                    </td>
                                    <td>25 مارس 2024</td>
                                    <td>صالح علي</td>

                                    <td><span class="pending">50 ريال </span></td>
                                    <td>
                                        <span class="pending"> في انتظار الدفع</span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
