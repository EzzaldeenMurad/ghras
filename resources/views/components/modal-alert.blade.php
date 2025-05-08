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
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                alertModal.show();
                setTimeout(function() {
                    alertModal.hide();
                }, 3000);
            });
        </script>
    @endif
@endsection
