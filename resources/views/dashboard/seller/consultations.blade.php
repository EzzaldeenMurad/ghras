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
                        <h5 class="card-title text-center">الإستشارات</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>المستشار</th>
                                    <th>تاريخ</th>
                                    <th>الموضوع</th>
                                    <th>الدفع</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        أسم المستشار
                                    </td>
                                    <td>10 مارس 2024</td>
                                    <td>جفاف التربة</td>

                                    <td><span class="pending">في إنتظار الدفع</span></td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn p-0 btn-sm action-icon" title="رفض"><i
                                                    class="fa-regular fa-circle-xmark text-danger"></i> </button>
                                            <button class="btn p-0 btn-sm action-icon" title="pay"><i
                                                    class="fa-brands fa-paypal"></i></button>
                                        </div>
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
