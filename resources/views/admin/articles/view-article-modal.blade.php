<!-- View Article Modal -->
<div class="modal fade" id="viewArticleModal" tabindex="-1" aria-labelledby="viewArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewArticleModalLabel">عرض المقال</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h4 id="viewArticleTitle"></h4>
                            <p class="text-muted">
                                <small>تاريخ النشر: <span id="viewArticleDate"></span></small>
                            </p>
                        </div>
                        <div class="mb-3">
                            <h5>وصف المقال:</h5>
                            <p id="viewArticleDescription"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img id="viewArticleImage" src="" alt="صورة المقال" class="img-fluid rounded">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
