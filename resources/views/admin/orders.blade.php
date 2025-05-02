@extends('layouts.master-with-header')

@section('title', 'لوحة التحكم| ادارة المقالات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.admin-sidebar')
        <!-- Main Content -->
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <h5 class="card-title text-center">إدارة الطلبات</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>تاريخ</th>
                                    <th>البايع</th>
                                    <th>المشتري</th>
                                    <th>الدفع</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="../assets/images/img1.png" alt="تمر سكري" class="product-img">
                                            <span>تمر سكري</span>
                                        </div>
                                    </td>
                                    <td>10 مارس 2024</td>
                                    <td>محمد السباعي</td>
                                    <td>فوائد السبيعي</td>

                                    <td>150 ريال</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn p-0 btn-sm action-icon" title="قبول"><i
                                                    class="fa-regular  fa-circle-check text-success"></i></button>
                                            <button class="btn p-0 btn-sm action-icon" title="رفض"><i
                                                    class="fa-regular fa-circle-xmark text-danger"></i> </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="../assets/images/img1.png" alt="تمر سكري" class="product-img">

                                            <span>تمر سكري</span>
                                        </div>
                                    </td>
                                    <td>10 مارس 2024</td>
                                    <td>محمد السباعي</td>
                                    <td>فوائد السبيعي</td>

                                    <td>150 ريال</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn p-0 btn-sm action-icon" title="قبول"><i
                                                    class="fa-regular  fa-circle-check text-success"></i></button>
                                            <button class="btn p-0 btn-sm action-icon" title="رفض"><i
                                                    class="fa-regular fa-circle-xmark text-danger"></i> </button>
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
