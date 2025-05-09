@extends('layouts.master-with-header')

@section('title', 'تعديل المنتج')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashbord.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <style>
        .upload-box {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 250px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-box:hover {
            background-color: #e9ecef;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .product-form {
            background-color: transparent !important;
            box-shadow: 0px 2.71px 12.21px 0px #4B465C1A;
            border-radius: 8px;
            padding: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-primary {
            background-color: #d2691e;
            border-color: #d2691e;
        }

        .btn-primary:hover {
            background-color: #b35a1f;
            border-color: #b35a1f;
        }

        .dropzone {
            border: 2px dashed #d2691e;
            border-radius: 8px;
            background-color: #f8f9fa;
            min-height: 150px;
        }

        .dropzone .dz-message {
            margin: 2em 0;
        }

        .dropzone .dz-preview .dz-image {
            border-radius: 8px;
        }

        .card {
            background-color: transparent !important;
            box-shadow: 0px 2.71px 12.21px 0px #4B465C1A !important;
            border: none;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('dashboard.partials.sidebar')
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">تعديل المنتج</h5>
                        <a href="{{ route('seller.products') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-right ml-1"></i> العودة للمنتجات
                        </a>
                    </div>

                    <form action="{{ route('seller.products.update', $product) }}" method="POST"
                        enctype="multipart/form-data" class="product-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">اسم المنتج</label>
                                    <input type="text" name="name" class="form-control" placeholder="تمور مخصصة"
                                        value="{{ old('name', $product->name) }}" required />
                                    @error('name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">سعر المنتج</label>
                                    <input type="number" name="price" class="form-control" placeholder="100"
                                        step="0.01" min="0" value="{{ old('price', $product->price) }}"
                                        required />
                                    @error('price')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">الفئة</label>
                                    <select name="category_id" class="form-select" required>
                                        <option value="">اختر الفئة</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">وصف المنتج</label>
                                    <textarea id="description-ckeditor-classic" name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">صور المنتج</label>
                                    <div id="image-dropzone" class="dropzone">
                                        <div class="dz-message" data-dz-message>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                fill="#CCC" class="mb-2" viewBox="0 0 16 16">
                                                <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                                                <path
                                                    d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z" />
                                            </svg>
                                            <p class="text-muted">اسحب وأفلت صورة المنتج هنا أو انقر للاختيار</p>
                                        </div>
                                    </div>
                                    <div id="dropzone-preview" class="row mt-2"></div>
                                    <div id="dropzone-preview-list" class="col-4 dz-preview dz-file-preview">
                                        <div class="dz-image" style="width: 90px; height: 100px">
                                            <img data-dz-thumbnail class="img-fluid rounded d-block h-100 w-100" />
                                        </div>
                                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span>
                                        </div>
                                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                        <a class="dz-remove" href="javascript:undefined;" data-dz-remove>إزالة</a>
                                    </div>
                                    <input type="file" name="images[]" id="image_url" multiple style="display: none;">
                                    @error('images')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                    @error('images.*')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> حفظ التعديلات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#description-ckeditor-classic'), {
                language: 'ar',
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'fontColor', 'fontBackgroundColor', '|',
                    'link', 'bulletedList', 'numberedList', '|',
                    'undo', 'redo'
                ]
            })
            .then(editor => {
                editor.ui.view.editable.element.setAttribute('dir', 'rtl');
            })
            .catch(error => {
                console.error('CKEditor Error:', error);
            });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        const previewListElement = document.getElementById("dropzone-preview-list");
        let previewTemplate = "";
        if (previewListElement) {
            previewTemplate = previewListElement.outerHTML;
            previewListElement.remove();
        } else {
            console.warn(`⚠️ تحذير: لم يتم العثور على قالب المعاينة. سيتم متابعة التهيئة بدون قالب.`);
        }
        const dropzone = new Dropzone("#image-dropzone", {
            url: '/dashboard/seller/products/{{ $product->id }}/edit', // رابط وهمي لتفادي الخطأ
            autoProcessQueue: false, // لمنع الرفع التلقائي
            previewTemplate: previewTemplate,
            previewsContainer: "#dropzone-preview",
            uploadMultiple: true,
            // addRemoveLinks: true,
            parallelUploads: 10,
            maxFiles: 10,
            maxFilesize: 5,
            acceptedFiles: "image/*",
            dictDefaultMessage: "اسحب وأفلت صورة المنتج هنا أو انقر للاختيار",
            // });


            init: function() {
                let dz = this;
                let input = document.getElementById("image_url");

                // عرض الصور الحالية للمنتج
                @if (isset($product->images) && count($product->images) > 0)
                    @foreach ($product->images as $index => $image)
                        var mockFile{{ $index }} = {
                            name: "{{ basename($image->image_url) }}",
                            size: 12345,
                            accepted: true,
                            status: Dropzone.ADDED
                        };
                        dz.emit("addedfile", mockFile{{ $index }});
                        dz.emit("thumbnail", mockFile{{ $index }}, "{{ asset($image->image_url) }}");
                        dz.emit("complete", mockFile{{ $index }});
                        dz.files.push(mockFile{{ $index }});
                    @endforeach
                @endif

                dz.on("addedfile", function() {
                    if (dz.files.length > 1) {
                        dz.files.forEach(function(file) {
                            file.previewElement.classList.remove("col-12");
                            file.previewElement.classList.add("col-4");
                        });

                    } else {
                        dz.files.forEach(function(file) {
                            file.previewElement.classList.remove("col-4");
                            file.previewElement.classList.add("col-12");
                        });
                    }
                    updateFileInput(dz, input);
                });
                this.on("success", function(file, response) {
                    // حفظ الـ id في كائن الملف لسهولة الوصول إليه لاحقاً
                    file.serverId = response.id; // تأكد أن الـ response يعيد id الصورة
                });

                dz.on("removedfile", function(file) {

                    if (file.name) {
                        console.log(document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'));
                        fetch('/dashboard/seller/image/delete', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                filename: file.name
                            })
                        }).then(response => {
                            if (response.ok) {
                                response.json().then(data => {
                                    document.getElementById('alertMessageJson')
                                        .textContent = data.message;
                                    var alertModal = new bootstrap.Modal(document
                                        .getElementById('alertModal'));
                                    alertModal.show();
                                    setTimeout(function() {
                                        alertModal.hide();
                                    }, 1800);
                                });

                            } else {
                                response.text().then(text => {
                                    console.error("فشل الحذف:", text);
                                });
                            }
                        });
                    }
                    updateFileInput(dz, input);
                });
            }
        });


        function updateFileInput(dropzone, input) {
            const dataTransfer = new DataTransfer();
            dropzone.files.forEach(file => {
                // إضافة ملفات File فقط إلى الإدخال
                if (file instanceof File) {
                    dataTransfer.items.add(file);
                }
            });
            input.files = dataTransfer.files;
        }
    </script>
@endsection
