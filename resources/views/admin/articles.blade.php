@extends('layouts.master-with-header')

@section('title', 'لوحة التحكم| ادارة المقالات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/articles.css') }}">
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.admin-sidebar')
        <!-- Main Content -->
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">أدارة المقالات</h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                            إضافة مقال
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>عنوان المقال</th>
                                    <th>وصف</th>
                                    <th>الصور</th>
                                    <th>تاريخ النشر</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>تمور خلاص</td>
                                    <td>وصف المقال</td>
                                    <td>
                                        <img src="https://images.pexels.com/photos/7474245/pexels-photo-7474245.jpeg"
                                            alt="تمور" class="article-img">
                                    </td>
                                    <td>10 مارس 2024</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn p-0 btn-sm action-icon" tabindex="-1"><i class="fas fa-eye "
                                                    title="عرض"></i></button>

                                            <button class="btn p-0 btn-sm action-icon"> <i class="fas fa-edit "
                                                    title="تعديل"></i></button>
                                            <button class="btn p-0 btn-sm action-icon"><i
                                                    class="fas fa-trash-alt  text-danger" title="حذف"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>تمور سكري</td>
                                    <td>وصف المقال</td>
                                    <td>
                                        <img src="https://images.pexels.com/photos/7195133/pexels-photo-7195133.jpeg"
                                            alt="تمور" class="article-img">
                                    </td>
                                    <td>25 مارس 2024</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn p-0 btn-sm action-icon" tabindex="-1"><i class="fas fa-eye "
                                                    title="عرض"></i></button>

                                            <button class="btn p-0 btn-sm action-icon"> <i class="fas fa-edit "
                                                    title="تعديل"></i></button>
                                            <button class="btn p-0 btn-sm action-icon"><i
                                                    class="fas fa-trash-alt  text-danger" title="حذف"></i></button>
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
    <!-- Add Article Modal -->
    @include('admin.add-articles-modal')
@endsection
