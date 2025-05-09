<div class="modal modal-md alert-modal fade" tabindex="-1" id="alertModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center d-flex justify-content-center align-items-center ">
                @if (session('success'))
                    <div id="alertMessage" class="fw-bold fs-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div id="alertMessage" class="fw-bold fs-4">
                        {{ session('error') }}
                    </div>
                @endif
                <div id="alertMessageJson" class="fw-bold fs-4">
                </div>

            </div>
        </div>
    </div>
</div>
