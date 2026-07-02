<?php

// 1. Bikin kerangka folder storage virtual untuk Vercel
$storageDir = '/tmp/storage';
$directories = [
    $storageDir . '/app',
    $storageDir . '/framework/cache/data',
    $storageDir . '/framework/sessions',
    $storageDir . '/framework/testing',
    $storageDir . '/framework/views',
    $storageDir . '/logs',
];

// 2. Eksekusi pembuatan folder
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 3. Jalankan aplikasi Laravel
require __DIR__ . '/../public/index.php';