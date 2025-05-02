@extends('layouts.master-with-header')

@section('title', 'الصفحة الشخصية')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashbord.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    <style>
        .profile-img-container {
            position: relative;
            cursor: pointer;
        }

        .change-photo-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        #imageUpload {
            display: none;
        }

        .profile-img {
            transition: filter 0.3s;
        }

        .profile-img-container:hover .profile-img {
            filter: brightness(0.8);
        }

        .profile-img-container:hover::after {
            content: 'تغيير الصورة';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('dashboard.partials.sidebar')

        <!-- Main Profile Content -->
        <div class="col-lg-9 mb-4">
            <form action="{{ route('profile.update') }}" method="POST" class="profile-container" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="profile-img-container" onclick="document.getElementById('imageUpload').click();">
                    <img src="{{ $user->image ? asset($user->image) : asset('assets/images/avatar_user.jpg') }}" alt="صورة المستخدم"
                        class="profile-img" id="profileImage">

                    <input type="file" name="image" id="imageUpload" accept="image/*">
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label for="username" class="form-label">اسم المستخدم</label>
                        <input type="text" class="form-control" id="username" name="name"
                            value="{{ $user->name ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="accountType" class="form-label">نوع الحساب</label>
                        <input type="text" class="form-control" id="accountType" readonly name="account_type"
                            value="{{ $user->role == 'buyer' ? 'زبون' : ($user->role == 'seller' ? 'تاجر' : ($user->role == 'consultant' ? 'مستشار' : '')) }}">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="region" class="form-label">المنطقة</label>
                        <input type="text" class="form-control" id="region" name="region"
                            value="{{ $user->region ?? '' }}">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn save-btn text-white">حفظ</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                    // Show success message
                    showImagePreviewMessage();
                }

                reader.readAsDataURL(e.target.files[0]);
            }
        });

        function showImagePreviewMessage() {
            // Create message element
            const messageDiv = document.createElement('div');

            // Insert after profile image container
            const imgContainer = document.querySelector('.profile-img-container');
            imgContainer.parentNode.insertBefore(messageDiv, imgContainer.nextSibling);

            // Auto remove after 5 seconds
            setTimeout(() => {
                messageDiv.remove();
            }, 5000);
        }
    </script>
@endsection
