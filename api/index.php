<?php

// SUNTIK PAKSA URL CLOUDINARY
putenv('CLOUDINARY_URL=cloudinary://344166586478737:0vdGgntEznTQXnPRMPnT9RVG7X0@dktmxduda');
$_ENV['CLOUDINARY_URL'] = 'cloudinary://344166586478737:0vdGgntEznTQXnPRMPnT9RVG7X0@dktmxduda';
$_SERVER['CLOUDINARY_URL'] = 'cloudinary://344166586478737:0vdGgntEznTQXnPRMPnT9RVG7X0@dktmxduda';

// ... (kode kerangka storage /tmp yang sebelumnya biarkan saja di bawah sini) ...
// 1. CUCI OTAK LARAVEL: Paksa lupakan cache dari tahap "Build" Vercel
// Kita alihkan semua target cache ke memori /tmp yang diizinkan Vercel
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');

// 2. Siapkan kerangka folder storage virtual di memori Vercel
$storageDir = '/tmp/storage';
$directories = [
    $storageDir . '/app',
    $storageDir . '/framework/cache/data',
    $storageDir . '/framework/sessions',
    $storageDir . '/framework/testing',
    $storageDir . '/framework/views',
    $storageDir . '/logs',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 3. Jalankan aplikasi Laravel dengan ingatan baru
require __DIR__ . '/../public/index.php';