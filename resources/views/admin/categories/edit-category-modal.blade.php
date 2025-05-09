      <!-- Edit Category Modal -->
      <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
          aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header border-0 pb-0"></div>
                  <div class="modal-body px-4 pt-0">
                      <div class="container">
                          <h1 class="title-modal text-center fw-bold mb-4">تعديل الفئة</h1>
                          <form action="{{ route('categories.update', $category) }}" method="POST"
                              enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="id" value="{{ $category->id }}">
                              <div class="row">
                                  <!-- Image Upload -->
                                  {{-- <div class="col-lg-4 mb-4">
                                      <label for="editCategoryImage{{ $category->id }}"
                                          class="form-label fw-bold text-start d-block">صورة
                                          الفئة</label>
                                      <input type="file" name="image_url" id="editCategoryImage{{ $category->id }}"
                                          class="form-control" accept="image/*">
                                      <div class="mt-2">
                                          <p class="mb-1">الصورة الحالية:</p>
                                          @if ($category->image_url)
                                              <img src="{{ asset($category->image_url) }}" alt="صورة الفئة"
                                                  class="img-fluid" style="max-height: 200px;">
                                          @else
                                              <span class="text-muted">لا توجد صورة</span>
                                          @endif
                                      </div>
                                      <small class="text-muted">اترك هذا الحقل فارغًا إذا كنت
                                          لا ترغب في تغيير الصورة</small>
                                  </div> --}}

                                  <!-- Name & Description -->
                                  <div class="section-left col-lg">
                                      <div class="mb-4">
                                          <label for="editCategoryName{{ $category->id }}"
                                              class="form-label fw-bold text-start d-block">اسم
                                              الفئة</label>
                                          <input type="text" name="name" class="form-control py-2"
                                              id="editCategoryName{{ $category->id }}" value="{{ $category->name }}"
                                              required>
                                      </div>
                                      <div class="mb-4">
                                          <label for="categoryNameParent{{ $category->id }}"
                                              class="form-label fw-bold text-start d-block">اختار
                                              الرئيسية له الفئة</label>
                                          <select name="parent_id" class="form-control py-2"
                                              id="categoryNameParent{{ $category->id }}">
                                              <option value="">الفئة الرئيسية</option>
                                              @foreach ($parentCategories as $parentCategory)
                                                  <option value="{{ $parentCategory->id }}"
                                                      {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }}>
                                                      {{ $parentCategory->name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="mb-4">
                                          <label for="editCategoryDescription{{ $category->id }}"
                                              class="form-label fw-bold text-start d-block">وصف
                                              الفئة</label>
                                          <textarea name="description" class="form-control py-2" id="editCategoryDescription{{ $category->id }}" rows="5">{{ $category->description }}</textarea>
                                      </div>
                                  </div>
                              </div>

                              <!-- Modal Footer -->
                              <div class="modal-footer border-0 d-flex justify-content-between mt-3">
                                  <div class="container">
                                      <div class="d-flex justify-content-center gap-4">
                                          <button type="button" class="btn px-4 py-2 fw-bold btn-custom btn-secondary"
                                              data-bs-dismiss="modal">إلغاء</button>
                                          <button type="submit"
                                              class="btn px-4 py-2 fw-bold btn-custom btn-primary">تحديث</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
