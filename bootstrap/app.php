<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // Jika kamu punya middleware custom, daftarkan di sini
        ]);

        $middleware->redirectTo(
            guests: '/login',
            users: function ($request) {
                $user = auth()->user();
                
                if (!$user || empty($user->role)) {
                    return '/login';
                }

                if ($user->role === 'Admin') {
                    return '/admin/dashboard';
                } 
                
                if ($user->role === 'Bidan') {
                    return '/bidan/dashboard';
                } 
                
                // 💡 UTAMA: Belokkan arahnya ke '/dashboard' (Pintu cek pendaftaran di web.php kamu)
                if ($user->role === 'Bumil') {
                    return '/dashboard'; 
                }

                return '/';
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();