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
                
                // Jika user entah bagaimana tidak punya role, tendang ke login
                if (!$user || empty($user->role)) {
                    return '/login';
                }

                // Logic sakti pembagian kamar Bumiloo berdasarkan Role
                if ($user->role === 'Admin') {
                    return '/admin/dashboard';
                } 
                
                if ($user->role === 'Bidan') {
                    return '/bidan/dashboard';
                } 
                
                if ($user->role === 'Bumil') {
                    return '/bumil/dashboard';
                }

                return '/'; // Default terakhir jika benar-benar mentok
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();