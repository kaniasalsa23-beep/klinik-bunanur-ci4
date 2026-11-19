<?php

use CodeIgniter\Boot;
use Config\Paths;

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */

$minPhpVersion = '8.2'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION,
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;

    exit(1);
}

/*
 *---------------------------------------------------------------
 * CPANEL SSL PROXY: Force HTTPS detection — MUST run BEFORE
 * CodeIgniter bootstraps so base_url() / site_url() / form_open()
 * always generate https:// URLs and clean routes (no index.php).
 *
 * cPanel terminates SSL at the load balancer and forwards plain
 * HTTP internally. CI4 reads $_SERVER['HTTPS'] to decide the
 * scheme; we patch it here from every known proxy header.
 *---------------------------------------------------------------
 */

// Method 1: Standard reverse proxy header (nginx/Apache mod_proxy)
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
    $_SERVER['HTTPS']       = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// Method 2: Some cPanel/WHM configurations use this header
if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) &&
    strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
    $_SERVER['HTTPS']       = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// Method 3: Cloudflare CDN (CF-Visitor header)
if (isset($_SERVER['HTTP_CF_VISITOR']) &&
    strpos($_SERVER['HTTP_CF_VISITOR'], '"https"') !== false) {
    $_SERVER['HTTPS']       = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// Method 4: X-Forwarded-Port header
if (isset($_SERVER['HTTP_X_FORWARDED_PORT']) &&
    (int)$_SERVER['HTTP_X_FORWARDED_PORT'] === 443) {
    $_SERVER['HTTPS']       = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// Method 5: Hardcoded domain lock — jika host adalah domain produksi,
// server ini SELALU HTTPS. Ini adalah fallback terakhir jika semua
// proxy header di atas tidak dikirim oleh cPanel.
if (isset($_SERVER['HTTP_HOST']) &&
    in_array($_SERVER['HTTP_HOST'], ['klinikbunanur.my.id', 'www.klinikbunanur.my.id'], true)) {
    $_SERVER['HTTPS']       = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// Normalize SCRIPT_NAME to prevent /public/ prefix in URLs when rewritten by Apache
if (isset($_SERVER['SCRIPT_NAME']) && str_starts_with($_SERVER['SCRIPT_NAME'], '/public/')) {
    $_SERVER['SCRIPT_NAME'] = substr($_SERVER['SCRIPT_NAME'], 7);
}

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// LOAD OUR PATHS CONFIG FILE
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Paths();

// Ensure writable directory exists in /tmp for serverless Vercel environment
$isServerless = (
    getenv('VERCEL') || isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) ||
    getenv('AWS_LAMBDA_FUNCTION_NAME') || isset($_SERVER['LAMBDA_TASK_ROOT'])
);
if ($isServerless) {
    $writable = '/tmp';
    foreach (['cache', 'logs', 'session', 'debugbar', 'uploads'] as $sub) {
        $dir = $writable . '/' . $sub;
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
    }
    $paths->writableDirectory = $writable;
}

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';

exit(Boot::bootWeb($paths));
