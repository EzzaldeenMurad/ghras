@extends('layouts.master-with-header')

@section('title', 'تعديل المستخدم')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
    <style>
        .user-image-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .form-section {
            /* background-color: #f8f9fa; */
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
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
                        <h5 class="card-title">تعديل المستخدم: {{ $user->name }}</h5>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                            العودة للمستخدمين
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column - User Image -->
                            <div class="col-md-4 text-center">
                                <div class="form-section">
                                    <h6 class="mb-3">صورة المستخدم</h6>
                                    <img src="{{ asset($user->image ?  $user->image : 'assets/images/consultant.png') }}"
                                        alt="{{ $user->name }}" class="user-image-preview" id="imagePreview">

                                    <div class="mb-3">
                                        <label for="image" class="form-label">تغيير الصورة</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            accept="image/*">
                                        <small class="text-muted">اترك هذا الحقل فارغًا إذا كنت لا ترغب في تغيير
                                            الصورة</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - User Details -->
                            <div class="col-md-8">
                                <div class="form-section">
                                    <h6 class="mb-3">معلومات المستخدم</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">الاسم الكامل</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="region" class="form-label">المنطقة</label>
                                            <input type="text" class="form-control" id="region" name="region"
                                                value="{{ old('region', $user->region) }}" >
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="role" class="form-label">نوع الحساب</label>
                                            <select class="form-select" id="role" name="role" required>
                                                <option value="admin"
                                                    {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>مدير
                                                </option>
                                                <option value="seller"
                                                    {{ old('role', $user->role) == 'seller' ? 'selected' : '' }}>تاجر
                                                </option>
                                                <option value="buyer"
                                                    {{ old('role', $user->role) == 'buyer' ? 'selected' : '' }}>زبون
                                                </option>
                                                <option value="consultant"
                                                    {{ old('role', $user->role) == 'consultant' ? 'selected' : '' }}>مستشار
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-primary px-4 mx-2">حفظ التغييرات</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary px-4 mx-2">إلغاء</a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
