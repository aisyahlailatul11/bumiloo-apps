<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    @if(session()->has('success'))
        Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
    @endif

    @if(session()->has('info'))
        Toast.fire({ icon: 'info', title: "{{ session('info') }}" });
    @endif
</script>