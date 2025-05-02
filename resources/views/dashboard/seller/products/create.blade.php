@extends('layouts.master')

@section('title', 'إنشاء منتج جديد')

@section('css')
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
            width: 250px;
            cursor: pointer;
            transition: all 0.3s;
            background-color: #FFFFFF66;
        }

        .upload-box:hover {
            border-color: #b87333;
        }

        .form-control::placeholder {
            color: #b8a99a;
        }

        input {
            width: 70% !important;
        }

        .btn-primary-custom {
            background-color: #d2691e;
            color: white;
            padding: 0.5rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary-custom:hover {
            background-color: #b87333;
            color: white;
        }

        .btn-secondary-custom {
            background-color: #606052;
            color: white;
            padding: 0.5rem 3rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }

        .btn-secondary-custom:hover {
            background-color: #4d4d40;
            color: white;
        }

        .form-control {
            background-color: transparent !important;
            border: 1px solid var(--border-color);
        }

        .new-product-page {
            width: 70%;
        }

        /* Dropzone custom styling */
        .dropzone {
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            background: #FFFFFF66;
            min-height: 250px;
            width: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .dropzone:hover {
            border-color: #b87333;
        }

        .dropzone .dz-message {
            text-align: center;
        }

        .dropzone .dz-preview {
            margin: 10px;
        }

        .dropzone .dz-preview .dz-image {
            border-radius: 8px;
            overflow: hidden;
            width: 200px;
            height: 200px;
            position: relative;
            display: block;
            z-index: 10;
        }

        .btn-delete-image {
            height: 22px;
            width: 40px;
            font-size: 12px;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        select.form-select {
            width: 70% !important;
            background-color: transparent !important;
            border: 1px solid var(--border-color);
        }

        .ck-editor__editable {
            min-height: 200px;
            background-color: transparent !important;
            color: #333;
            font-size: 16px;
            font-family: Arial, sans-serif;
        }

        .ck-toolbar_grouping {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: transparent !important;
        }

        .ck-editor__editable:focus {
            border-color: var(--border-color) !important;
        }
    </style>
@endsection

@section('content')
    <div class="new-product-page container py-4">
        <h1 class="text-start fw-bold fs-2 my-4">إنشاء منتج جديد</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
            @csrf
            <div class="row g-4 flex-md-row-reverse">
                <div class="col-md-4 d-flex justify-content-center">
                    <div class="d-flex flex-column align-items-center">
                        <div id="image-dropzone" class="dropzone">

                        </div>
                        <div class="row list-unstyled mb-0 d-flex" id="dropzone-preview">
                            <div class="col-4 mt-2 px-2" id="dropzone-preview-list">
                                <div class="border rounded">
                                    <div class=" align-items-center">
                                        <div class="flex-shrink-0 ">
                                            <div class="avatar-sm bg-light rounded overflow-hidden">
                                                <img data-dz-thumbnail class="img-fluid rounded d-block" src="#"
                                                    alt="Product-Image" />
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 text-center mt-1">
                                            <button data-dz-remove
                                                class="btn btn-delete-image btn-sm btn-danger w-8 h-8">حذف</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="file" name="images[]" id="image_url" style="display: none; " multiple />
                        @error('image_url')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-medium">اسم المنتج</label>
                        <input type="text" name="name" class="form-control" placeholder="تمور مخصصة"
                            value="{{ old('name') }}" required />
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">سعر المنتج</label>
                        <input type="number" name="price" class="form-control" placeholder="100" step="0.01"
                            min="0" value="{{ old('price') }}" required />
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
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control  @error('description') is-invalid @enderror" id="description-ckeditor-classic"
                            name="description" rows="3" placeholder="اكتب وصف للمنتج">{{ old('description', $product->description ?? '') }}</textarea>

                        {{-- <label class="form-label fw-medium">وصف المنتج</label>
                        <textarea name="description" class="form-control" placeholder="اكتب وصف للمنتج" rows="3">{{ old('description') }}</textarea> --}}
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3 mt-5">
                <a href="{{ route('seller.products.index') }}" class="btn btn-secondary-custom">إلغاء</a>
                <button type="submit" class="btn btn-primary-custom">إنشاء منتج جديد</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    {{-- <script src="{{ asset('assets/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script> --}}
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
            console.warn(`⚠️ تحذير: لم يتم العثور على قالب المعاينة "${previewListClass}". سيتم متابعة التهيئة بدون قالب.`);
        }
        const dropzone = new Dropzone("#image-dropzone", {
            url: "#", // غير مستخدم
            autoProcessQueue: false,
            previewTemplate: previewTemplate,
            previewsContainer: "#dropzone-preview",
            uploadMultiple: true, // ✅
            parallelUploads: 10, // عدد الصور الممكن رفعها دفعة واحدة
            maxFiles: 10, // أقصى عدد صور
            maxFilesize: 5, // الحد الأقصى لكل صورة
            acceptedFiles: "image/*",
            dictDefaultMessage: `
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#CCC" class="mb-2" viewBox="0 0 16 16">
                    <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                    <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z" />
                </svg>
                <p class="text-muted">اسحب وأفلت صورة المنتج هنا أو انقر للاختيار</p>
            `,

            init: function() {
                let dz = this;
                let input = document.getElementById("image_url");

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

                dz.on("removedfile", function() {
                    updateFileInput(dz, input);
                });
            }
        });


        function updateFileInput(dropzone, input) {
            const dataTransfer = new DataTransfer();
            dropzone.files.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }
    </script>
@endsection
