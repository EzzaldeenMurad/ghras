@extends('layouts.master-with-header')

@section('title', 'لوحة التحكم| ادارة الفئات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
    <style>
        .category-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
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
                        <h5 class="card-title">إدارة الفئات</h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            إضافة فئة جديدة
                        </button>
                    </div>

                    @include('alerts.success')


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>اسم الفئة</th>
                                    <th>الوصف</th>
                                    <th>الصورة</th>
                                    <th>التصنيف التابع</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <!-- filepath: e:\myProjects\laravel\laravel_project\ghras\resources\views\admin\categories\index.blade.php -->
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ Str::limit($category->description, 50) }}</td>
                                        <td>
                                            @if ($category->image_url)
                                                <img src="{{ asset($category->image_url) }}" alt="{{ $category->name }}"
                                                    class="category-img">
                                            @else
                                                <span class="text-muted">لا توجد صورة</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->children->count() > 0 ? $category->children->pluck('name')->implode(', ') : 'رئيسي' }}
                                        </td>
                                        <td>{{ $category->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button class="btn p-0 btn-sm action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal{{ $category->id }}">
                                                    <i class="fas fa-edit" title="تعديل"></i>
                                                </button>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn p-0 btn-sm action-icon"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟')">
                                                        <i class="fas fa-trash-alt text-danger" title="حذف"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('admin.categories.edit-category-modal')

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا توجد فئات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    @include('admin.categories.add-category-modal')

@endsection

@section('scripts')
    <script>
        // Image preview for add modal
        $('#categoryImage').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagePreview').removeClass('d-none').find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        // Image preview for edit modal
        $('#editCategoryImage').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#editImagePreview').removeClass('d-none').find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
