<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* --- ANIMASI GRADASI BERGERAK PADA BACKGROUND BELAKANG --- */
            body { 
                font-family: 'Poppins', sans-serif; 
                margin: 0;
                width: 100vw;
                height: 100vh;
                overflow: hidden;
                
                /* Perpaduan warna selaras: Off-white, Soft Pink, dan Rose Pastel */
                background: linear-gradient(-45deg, #FAFAFA, #FFF0F3, #FFE5EC, #FAFAFA);
                background-size: 400% 400%;
                animation: gradientMove 12s ease infinite;
            }

            @keyframes gradientMove {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* --- ANIMASI TAMBAHAN UNTUK SLOT LOGIN (CARD) --- */
            .card-appearance {
                animation: scaleUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            @keyframes scaleUp {
                from {
                    opacity: 0;
                    transform: scale(0.95) translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
            }
        </style>
    </head>
    <body class="antialiased">
        
        <div class="min-h-screen w-full flex items-center justify-center p-4">
            
            <div class="w-full max-w-4xl card-appearance flex justify-center items-center">
                {{ $slot }}
            </div>

        </div>

    </body>
</html>