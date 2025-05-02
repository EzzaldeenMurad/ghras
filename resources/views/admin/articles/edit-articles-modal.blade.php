<!-- Edit Article Modal -->
<div class="modal fade" id="editArticleModal" tabindex="-1" aria-labelledby="editArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0"></div>

            <div class="modal-body px-4 pt-0">
                <div class="container">
                    <h1 class="title-modal text-center fw-bold mb-2">تعديل المقال</h1>

                    <!-- Main form -->
                    <form id="editArticleForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editArticleId" name="id">
                        <div class="row">
                            <!-- Image Upload -->
                            <div class="col-lg-4 mb-4">
                                <label for="editImage" class="form-label fw-bold text-start d-block">صورة المقال</label>
                                <input type="file" name="image_url" id="editImage" class="form-control"
                                    accept="image/*">
                                <div class="mt-2">
                                    <p class="mb-1">الصورة الحالية:</p>
                                    <img id="currentArticleImage" src="" alt="صورة المقال" class="img-fluid"
                                        style="max-height: 200px;">
                                </div>
                                <div id="editImagePreview" class="mt-2 d-none">
                                    <p class="mb-1">الصورة الجديدة:</p>
                                    <img src="" alt="معاينة الصورة" class="img-fluid"
                                        style="max-height: 200px;">
                                </div>
                                <small class="text-muted">اترك هذا الحقل فارغًا إذا كنت لا ترغب في تغيير الصورة</small>
                            </div>

                            <!-- Title & Description -->
                            <div class="section-left col-lg-8">
                                <div class="mb-4">
                                    <label for="editArticleTitle" class="form-label fw-bold text-start d-block">عنوان
                                        المقالة</label>
                                    <input type="text" name="title" class="form-control py-2" id="editArticleTitle"
                                        required>
                                </div>

                                <div class="mb-4">
                                    <label for="editArticleDescription"
                                        class="form-label fw-bold text-start d-block">وصف المقال</label>
                                    <textarea name="content" class="form-control py-2" id="editArticleDescription" rows="8" required></textarea>
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
