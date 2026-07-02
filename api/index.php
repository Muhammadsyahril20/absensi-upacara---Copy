<?php

// 1. Buat folder virtual di memori Vercel biar Laravel bebas nulis file
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

// 2. Paksa Laravel pakai konfigurasi Serverless
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');
putenv('APP_DEBUG=true');

// 3. Panggil inti Laravel
require __DIR__ . '/../public/index.php';