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
                        <h5 class="card-title text-center">سجل المشتريات</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>تاريخ</th>
                                    <th>البايع</th>
                                    <th>الدفع</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="../../assets/images/img1.png" alt="تمر سكري" class="product-img">
                                            <span>تمر سكري</span>
                                        </div>
                                    </td>
                                    <td>10 مارس 2024</td>
                                    <td>محمد السبيعي</td>

                                    <td><span class="price">150 ريال</span></td>

                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="../../assets/images/img1.png" alt="تمر سكري" class="product-img">
                                            <span>تمر سكري</span>
                                        </div>
                                    </td>
                                    <td>15 مارس 2024</td>
                                    <td>محمد السبيعي</td>

                                    <td><span class="price">300 ريال</span></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
