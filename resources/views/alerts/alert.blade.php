@if (session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
            alertModal.show();
            setTimeout(function() {
                alertModal.hide();
            }, 1800);
        });
    </script>
@endif
