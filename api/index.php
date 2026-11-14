<?php

/**
 * Vercel Serverless Entrypoint (vercel-php@0.7.1)
 * Prepares writable /tmp directories on read-only serverless container before booting Laravel.
 */
$tmpDirs = [
    '/tmp/views',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($tmpDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';
