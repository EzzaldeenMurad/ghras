<script>
    toastr.options = {
        "positionClass": "toast-top-left",
        "rtl": true,
        timeOut: 5000, // 5 seconds
        closeButton: true,
        progressBar: true,
        newestOnTop: true
    };
    @if (session('success'))
        toastr.success('{{ session('success') }}');
    @endif

    @if (session('info'))
        toastr.info('{{ session('info') }}');
    @endif

    @if (session('warning'))
        toastr.warning('{{ session('warning') }}');
    @endif

    @if (session('error'))
        toastr.error('{{ session('error') }}');
    @endif
</script>
