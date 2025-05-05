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

        /* Certificate styles */
        .certificates-section {
            margin-top: 30px;
            /* background-color: #f8f9fa; */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }

        .certificates-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .certificate-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            height: 200px;
            transition: transform 0.3s;
        }

        .certificate-item:hover {
            transform: translateY(-5px);
        }

        .certificate-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .certificate-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px;
            font-size: 0.9rem;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .certificate-item:hover .certificate-overlay {
            opacity: 1;
        }

        .certificate-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
        }

        .certificate-actions button {
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
        }

        .certificate-actions button:hover {
            background: rgba(220, 53, 69, 0.8);
        }

        .add-certificate {
            height: 200px;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-certificate:hover {
            background-color: #e9ecef;
        }

        .add-certificate i {
            font-size: 2rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        #certificateUpload {
            display: none;
        }

        .modal-content {
            background-color:var(--secondary-color);
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
                    <img src="{{ $user->image ? asset($user->image) : asset('assets/images/avatar_user.jpg') }}"
                        alt="صورة المستخدم" class="profile-img" id="profileImage">

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

            <!-- Certificates Section for Consultants -->
            @if ($user->role == 'consultant')
                <div class="certificates-section">
                    <h3 class="section-title">الشهادات والمؤهلات</h3>

                    @if (session('certificate_success'))
                        <div class="alert alert-success">
                            {{ session('certificate_success') }}
                        </div>
                    @endif

                    @if (session('certificate_error'))
                        <div class="alert alert-danger">
                            {{ session('certificate_error') }}
                        </div>
                    @endif

                    <div class="certificates-gallery">
                        @forelse($user->certificates as $certificate)
                            <div class="certificate-item">
                                <img src="{{ asset($certificate->image_path) }}" alt="شهادة" class="certificate-img"
                                    onclick="viewCertificate('{{ asset($certificate->image_path) }}')">
                                <div class="certificate-overlay">
                                    {{ $certificate->title ?? 'شهادة ' . $loop->iteration }}
                                </div>
                                <div class="certificate-actions">
                                    <button type="button" onclick="deleteCertificate({{ $certificate->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted">لم يتم إضافة أي شهادات بعد.</p>
                            </div>
                        @endforelse

                        <!-- Add Certificate Button -->
                        <div class="add-certificate" onclick="document.getElementById('certificateUpload').click();">
                            <i class="fas fa-plus-circle"></i>
                            <span>إضافة شهادة جديدة</span>
                        </div>
                    </div>

                    <form id="certificateForm" action="{{ route('certificates.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="certificate_image" id="certificateUpload" accept="image/*">
                        <input type="hidden" name="title" id="certificateTitle">
                    </form>

                    <form id="deleteCertificateForm" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Certificate View Modal -->
    <div class="modal fade" id="viewCertificateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">عرض الشهادة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img src="" id="certificateImage" class="img-fluid w-100" alt="شهادة">
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Title Modal -->
    <div class="modal fade" id="certificateTitleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة عنوان للشهادة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titleInput" class="form-label">عنوان الشهادة</label>
                        <input type="text" class="form-control" id="titleInput" placeholder="أدخل عنوان الشهادة">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" onclick="submitCertificate()">حفظ وإضافة</button>
                </div>
            </div>
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

        // Certificate handling functions
        document.getElementById('certificateUpload').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                // Show the title modal
                var titleModal = new bootstrap.Modal(document.getElementById('certificateTitleModal'));
                titleModal.show();
            }
        });

        function submitCertificate() {
            const title = document.getElementById('titleInput').value;
            document.getElementById('certificateTitle').value = title;

            // Close the modal
            var titleModal = bootstrap.Modal.getInstance(document.getElementById('certificateTitleModal'));
            titleModal.hide();

            // Submit the form
            document.getElementById('certificateForm').submit();
        }

        function viewCertificate(imagePath) {
            document.getElementById('certificateImage').src = imagePath;
            var modal = new bootstrap.Modal(document.getElementById('viewCertificateModal'));
            modal.show();
        }

        function deleteCertificate(certificateId) {
            if (confirm('هل أنت متأكد من حذف هذه الشهادة؟')) {
                const form = document.getElementById('deleteCertificateForm');
                const url = "{{ route('certificates.destroy', ':id') }}".replace(':id', certificateId);
                form.action = url;
                form.submit();
            }
        }
    </script>
@endsection
