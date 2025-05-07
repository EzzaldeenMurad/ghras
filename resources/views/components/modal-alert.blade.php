<div class="modal modal-md alert-modal fade" tabindex="-1" id="alertModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                @if (session('success'))
                    <div id="alertMessage">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div id="alertMessage">
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
