<!-- Article Modal -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0"></div>

            <div class="modal-body px-4 pt-0">
                <div class="container">
                    <h1 class="title-modal text-center fw-bold mb-2">إنشاء مقال جديد</h1>

                    <!-- Main form -->
                    <form id="articleForm" action="{{ route('admin.articles.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Image Upload -->
                            <div class="col-lg-4 mb-4">
                                <label for="image" class="form-label fw-bold text-start d-block">صورة المقال</label>
                                <input type="file" name="image_url" id="image" class="form-control"
                                    accept="image/*" required>
                                <div id="imagePreview" class="mt-2 d-none">
                                    <img src="" alt="معاينة الصورة" class="img-fluid"
                                        style="max-height: 200px;">
                                </div>
                            </div>

                            <!-- Title & Description -->
                            <div class="section-left col-lg-8">
                                <div class="mb-4">
                                    <label for="articleTitle" class="form-label fw-bold text-start d-block">عنوان
                                        المقالة</label>
                                    <input type="text" name="title" class="form-control py-2" id="articleTitle"
                                        placeholder="مثال ... تمور معلبة في الرياض" required>
                                </div>

                                <div class="mb-4">
                                    <label for="articleDescription" class="form-label fw-bold text-start d-block">وصف
                                        المقال</label>
                                    <textarea name="content" class="form-control py-2" id="articleDescription" rows="8"
                                        placeholder="اكتب وصف المقال هنا..." required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer border-0 d-flex justify-content-between mt-3">
                            <div class="container">
                                <div class="d-flex justify-content-center gap-4">
                                    <!-- Cancel Button -->
                                    <button type="button" class="btn px-4 py-2 fw-bold btn-custom btn-secondary"
                                        data-bs-dismiss="modal">
                                        إلغاء
                                    </button>
                                    <!-- Submit Button -->
                                    <button type="submit" class="btn px-4 py-2 fw-bold btn-custom btn-primary">
                                        حفظ ونشر
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
