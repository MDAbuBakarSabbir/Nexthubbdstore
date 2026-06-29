<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// If the URI starts with /public, strip it and check if it exists in the public directory.
// This handles asset('public/...') when the document root is set to public.
if (strpos($uri, '/public/') === 0) {
    $realPath = __DIR__ . '/public' . substr($uri, 7); // '/public/foo' -> '/public/foo'
    if (file_exists($realPath) && !is_dir($realPath)) {
        // Serve the file directly
        $extension = pathinfo($realPath, PATHINFO_EXTENSION);
        $contentTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'ico' => 'image/x-icon',
        ];
        if (isset($contentTypes[$extension])) {
            header('Content-Type: ' . $contentTypes[$extension]);
        }
        readfile($realPath);
        exit;
    }
}

// Default Laravel serve emulation:
// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a
// Laravel application without having installed a "real" web server software
// here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
