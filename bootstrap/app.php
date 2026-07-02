<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // JURUS BONGKAR KEDOK: Paksa Laravel nampilin error asli dalam bentuk Teks/JSON
        // Ini akan mem-bypass mesin View yang crash di Vercel
        $exceptions->shouldRenderJsonWhen(function (Request $request, \Throwable $e) {
            return true;
        });
    })->create();

// Pindahkan storage ke memori sementara (Khusus Vercel)
$app->useStoragePath('/tmp/storage');

return $app;