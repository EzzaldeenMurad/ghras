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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>عنوان المقال</th>
                                    <th>وصف</th>
                                    <th>الصورة</th>
                                    <th>تاريخ النشر</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($articles as $article)
                                    <tr>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ Str::limit($article->content, 50) }}</td>
                                        <td>
                                            <img src="{{ $article->image_url ? asset($article->image_url) : asset('assets/images/logo.png') }}"
                                                alt="{{ $article->title }}" class="article-img">
                                        </td>
                                        <td>{{ $article->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-end">
                                                {{-- <button class="btn p-0 btn-sm action-icon show-article"
                                                    data-id="{{ $article->id }}" tabindex="-1">
                                                    <i class="fas fa-eye" title="عرض"></i>
                                                </button> --}}
                                                <button class="btn p-0 btn-sm action-icon edit-article"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editArticleModal{{ $article->id }}">
                                                    <i class="fas fa-edit" title="تعديل"></i>
                                                </button>
                                                <form action="{{ route('admin.articles.destroy', $article) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn p-0 btn-sm action-icon"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
                                                        <i class="fas fa-trash-alt text-danger" title="حذف"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal لكل مقال -->
                                    <div class="modal fade" id="editArticleModal{{ $article->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-full">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 pb-0"></div>

                                                <div class="modal-body px-4 pt-0">
                                                    <div class="container">
                                                        <h1 class="title-modal text-center fw-bold mb-2">تعديل المقال</h1>

                                                        <form action="{{ route('admin.articles.update', $article->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <!-- صورة المقال -->
                                                                <div class="col-lg-4 mb-4">
                                                                    <label for="editImage"
                                                                        class="form-label fw-bold text-start d-block">صورة
                                                                        المقال</label>
                                                                    <input type="file" name="image_url" id="editImage"
                                                                        class="form-control" accept="image/*">

                                                                    {{-- <input type="file" name="image_url"
                                                                        class="form-control" accept="image/*"> --}}
                                                                    <div id="currentImageContainer" class="mt-2">
                                                                        <p class="mb-1">الصورة الحالية:</p>
                                                                        <img id="currentArticleImage"
                                                                            src="{{ asset($article->image_url ?? 'assets/images/logo.png') }}"
                                                                            alt="صورة المقال" class="img-fluid"
                                                                            style="max-height: 200px; border-radius: 8px;">
                                                                    </div>
                                                                    <div id="editImagePreview" class="mt-2 d-none">
                                                                        <p class="mb-1">الصورة الجديدة:</p>
                                                                        <img src="" alt="معاينة الصورة"
                                                                            class="img-fluid" style="max-height: 200px;">
                                                                    </div>
                                                                </div>

                                                                <!-- العنوان والمحتوى -->
                                                                <div class="section-left col-lg-8">
                                                                    <div class="mb-4">
                                                                        <label
                                                                            class="form-label fw-bold text-start d-block">عنوان
                                                                            المقالة</label>
                                                                        <input type="text" name="title"
                                                                            class="form-control py-2"
                                                                            value="{{ $article->title }}" required>
                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <label
                                                                            class="form-label fw-bold text-start d-block">وصف
                                                                            المقال</label>
                                                                        <textarea name="content" class="form-control py-2" rows="8" required>{{ $article->content }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- أزرار الحفظ والإلغاء -->
                                                            <div
                                                                class="modal-footer border-0 d-flex justify-content-between mt-3">
                                                                <div class="container">
                                                                    <div class="d-flex justify-content-center gap-4">
                                                                        <button type="button"
                                                                            class="btn px-4 py-2 fw-bold btn-custom btn-secondary"
                                                                            data-bs-dismiss="modal">إلغاء</button>
                                                                        <button type="submit"
                                                                            class="btn px-4 py-2 fw-bold btn-custom btn-primary">
                                                                            تحديث المقال
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا توجد مقالات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Article Modal -->
    @include('admin.articles.add-articles-modal')

    <!-- Edit Article Modal -->
    @include('admin.articles.edit-articles-modal')

    <!-- View Article Modal -->
    {{-- @include('admin.articles.view-article-modal') --}}
@endsection

@section('scripts')
    <script>
        // Show article details
        // $(document).on('click', '.show-article', function() {
        //     let articleId = $(this).data('id');
        //     $.ajax({
        //         url: "{{ url('admin/articles') }}/" + articleId,
        //         type: 'GET',
        //         success: function(response) {
        //             let article = response.article;
        //             $('#viewArticleTitle').text(article.title);
        //             $('#viewArticleDescription').text(article.content);
        //             $('#viewArticleImage').attr('src', "{{ asset('storage') }}/" + article.image_url);
        //             $('#viewArticleDate').text(new Date(article.created_at).toLocaleDateString(
        //                 'ar-SA'));
        //             $('#viewArticleModal').modal('show');
        //         }
        //     });
        // });

        // Load article data for editing
        // $(document).on('click', '.edit-article', function() {
        //     let articleId = $(this).data('id');
        //     console.log(articleId);
        //     $.ajax({
        //         url: "{{ url('dashboard/admin/articles') }}/" + articleId + "/edit",
        //         type: 'GET',
        //         success: function(response) {
        //             let article = response.article;
        //             $('#editArticleId').val(article.id);
        //             $('#editArticleTitle').val(article.title);
        //             $('#editArticleDescription').val(article.content);
        //             $('#currentArticleImage').attr('src', "{{ asset($article->image_url) }}");
        //             $('#editArticleForm').attr('action', "{{ url('admin/articles') }}/" + article.id +
        //                 "/update");
        //             $('#editArticleModal').modal('show');
        //         }
        //     });
        // });

        // Image preview for add modal
        $('#image').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagePreview').removeClass('d-none').find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        // Image preview for edit modal
        $('#editImage').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#currentImageContainer').addClass('d-none').find('img').attr('src', e.target.result);
                $('#editImagePreview').removeClass('d-none').find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
