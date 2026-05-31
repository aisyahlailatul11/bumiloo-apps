<script>
    // Hanya fokus ke Toast untuk notifikasi sukses/info
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: { popup: 'rounded-xl shadow-lg px-6 py-4 font-poppins font-medium' }
    });

    @if(session()->has('success')) 
        Toast.fire({ icon: 'success', title: "{{ session('success') }}", background: '#e1f3e6', color: '#1E293B' }); 
    @endif

    @if(session()->has('info')) 
        Toast.fire({ icon: 'info', title: "{{ session('info') }}", background: '#ecf7ff', color: '#1E40AF' }); 
    @endif
    
    @if(session()->has('error')) 
        Toast.fire({ icon: 'error', title: "{{ session('error') }}", background: '#FEE2E2', color: '#991B1B' }); 
    @endif
</script>