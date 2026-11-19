<?php

/**
 * Root index.php — cPanel public_html Entry Point
 *
 * Di cPanel dengan deployment "full project → public_html/",
 * .htaccess merewrite semua request ke public/index.php.
 * File ini adalah fallback keamanan jika mod_rewrite tidak aktif.
 *
 * PENTING: HTTPS detection di sini identik dengan public/index.php
 * sehingga base_url() selalu menghasilkan https:// di semua skenario.
 */

// ============================================================
// CPANEL SSL PROXY: Force HTTPS — 5 metode deteksi
// ============================================================

$host = (string)($_SERVER['HTTP_HOST'] ?? '');
$isLocal = str_contains($host, 'localhost') || str_contains($host, '127.0.0.1');

if (!$isLocal) {
    // Method 1: Standard reverse proxy (nginx/Apache mod_proxy)
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
        $_SERVER['HTTPS']       = 'on';
        $_SERVER['SERVER_PORT'] = 443;
    }

    // Method 2: WHM/cPanel proprietary header
    if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) &&
        strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
        $_SERVER['HTTPS']       = 'on';
        $_SERVER['SERVER_PORT'] = 443;
    }

    // Method 3: Cloudflare CDN
    if (isset($_SERVER['HTTP_CF_VISITOR']) &&
        strpos($_SERVER['HTTP_CF_VISITOR'], '"https"') !== false) {
        $_SERVER['HTTPS']       = 'on';
        $_SERVER['SERVER_PORT'] = 443;
    }

    // Method 4: Forwarded port
    if (isset($_SERVER['HTTP_X_FORWARDED_PORT']) &&
        (int)$_SERVER['HTTP_X_FORWARDED_PORT'] === 443) {
        $_SERVER['HTTPS']       = 'on';
        $_SERVER['SERVER_PORT'] = 443;
    }

    // Method 5: Domain lock — domain produksi ini SELALU HTTPS
    if (in_array($host, ['klinikbunanur.my.id', 'www.klinikbunanur.my.id'], true)) {
        $_SERVER['HTTPS']       = 'on';
        $_SERVER['SERVER_PORT'] = 443;
    }
}

// Normalize SCRIPT_NAME to prevent /public/ prefix in URLs
if (isset($_SERVER['SCRIPT_NAME']) && str_starts_with($_SERVER['SCRIPT_NAME'], '/public/')) {
    $_SERVER['SCRIPT_NAME'] = substr($_SERVER['SCRIPT_NAME'], 7);
}

// ============================================================
// Delegate ke front controller CI4 yang sebenarnya di public/
// ============================================================
$publicIndex = __DIR__ . '/public/index.php';

if (file_exists($publicIndex)) {
    chdir(__DIR__ . '/public');
    require $publicIndex;
} else {
    http_response_code(500);
    echo 'Application entry point not found. Check deployment structure.';
    exit(1);
}
