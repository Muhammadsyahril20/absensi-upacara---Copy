<?php

// 1. Hapus SEMUA file cache bawaan dari laptop lokal yang bikin Vercel crash
$cachePath = __DIR__ . '/../bootstrap/cache/';
$cacheFiles = glob($cachePath . '*.php');

if ($cacheFiles) {
    foreach ($cacheFiles as $file) {
        @unlink($file); // Hapus file cache secara paksa
    }
}

// 2. Siapkan folder memori sementara (/tmp) karena file manager Vercel di-kunci (Read-Only)
if (!is_dir('/tmp/views')) {
    @mkdir('/tmp/views', 0777, true);
}

// Paksa Laravel menggunakan folder /tmp untuk menyimpan hasil render tampilan
putenv('VIEW_COMPILED_PATH=/tmp/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/views';

// 3. Jalankan mesin utama Laravel
require __DIR__ . '/../public/index.php';