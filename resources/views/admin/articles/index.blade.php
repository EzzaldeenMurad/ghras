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

                    @include('alerts.success')


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
                                            <img src="{{ asset($article->image_url) }}" alt="{{ $article->title }}"
                                                class="article-img">
                                        </td>
                                        <td>{{ $article->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-end">
                                                {{-- <button class="btn p-0 btn-sm action-icon show-article"
                                                    data-id="{{ $article->id }}" tabindex="-1">
                                                    <i class="fas fa-eye" title="عرض"></i>
                                                </button> --}}
                                                <button class="btn p-0 btn-sm action-icon edit-article"
                                                    data-id="{{ $article->id }}">
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
        $(document).on('click', '.edit-article', function() {
            let articleId = $(this).data('id');
            console.log(articleId);
            $.ajax({
                url: "{{ url('admin/articles') }}/" + articleId + "/edit",
                type: 'GET',
                success: function(response) {
                    let article = response.article;
                    $('#editArticleId').val(article.id);
                    $('#editArticleTitle').val(article.title);
                    $('#editArticleDescription').val(article.content);
                    $('#currentArticleImage').attr('src', "{{ asset($article->image_url) }}");
                    $('#editArticleForm').attr('action', "{{ url('admin/articles') }}/" + article.id +
                        "/update");
                    $('#editArticleModal').modal('show');
                }
            });
        });

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
                $('#editImagePreview').removeClass('d-none').find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
