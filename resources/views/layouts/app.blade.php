<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">

        <title>{{ config('app.name', 'Bumiloo') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            // Script untuk memastikan jika session habis, halaman otomatis redirect ke login
            document.addEventListener('DOMContentLoaded', function() {
                if (window.performance && window.performance.navigation.type === 2) {
                    location.reload(true);
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success_register'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Registrasi!',
            text: "{{ session('success_register') }}",
            confirmButtonColor: '#F875AA'
        });
    @endif

    @if(session('success_pendaftaran'))
        Swal.fire({
            icon: 'success',
            title: 'Data Tersimpan!',
            text: "{{ session('success_pendaftaran') }}",
            confirmButtonColor: '#F875AA'
        });
    @endif
</script>
    </body>
</html>