<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0"></div>

            <div class="modal-body px-4 pt-0">
                <div class="container">
                    <h1 class="title-modal text-center fw-bold mb-4">إضافة فئة جديدة</h1>

                    <!-- Main form -->
                    <form id="categoryForm" action="{{ route('categories.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Image Upload -->
                            {{-- <div class="col-lg-4 mb-4">
                                <label for="categoryImage" class="form-label fw-bold text-start d-block">صورة
                                    الفئة</label>
                                <input type="file" name="image_url" id="categoryImage" class="form-control"
                                    accept="image/*">
                                <div id="imagePreview" class="mt-2 d-none">
                                    <img src="" alt="معاينة الصورة" class="img-fluid"
                                        style="max-height: 200px;">
                                </div>
                            </div> --}}

                            <!-- Name & Description -->
                            <div class="section-left col-lg">
                                <div class="mb-4">
                                    <label for="categoryName" class="form-label fw-bold text-start d-block">اسم
                                        الفئة</label>
                                    <input type="text" name="name" class="form-control py-2" id="categoryName"
                                        placeholder="مثال ... تمور الموسم" required>
                                </div>
                                <div class="mb-4">
                                    <label for="categoryName" class="form-label fw-bold text-start d-block">اختار
                                        الرئيسية له الفئة</label>
                                    <select name="parent_id" id="" class="form-control py-2"
                                        id="categoryNameParent">
                                        <option value="">الفئة الرئيسية</option>
                                        @foreach ($parentCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="categoryDescription" class="form-label fw-bold text-start d-block">وصف
                                        الفئة</label>
                                    <textarea name="description" class="form-control py-2" id="categoryDescription" rows="5"
                                        placeholder="اكتب وصف الفئة هنا..."></textarea>
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
                                        حفظ
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
