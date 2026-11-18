<?php

/**
 * Vercel Serverless PHP Bridge for CodeIgniter 4
 *
 * This bridge initializes the ephemeral serverless environment, ensures
 * writable directory paths exist in /tmp, and forwards requests to the
 * main CodeIgniter 4 front controller in /public/index.php.
 */

// Auto-create ephemeral runtime directories in /tmp before CI4 boots
$ephemeralDirs = [
    '/tmp/cache',
    '/tmp/session',
    '/tmp/logs',
    '/tmp/debugbar',
    '/tmp/uploads',
];

foreach ($ephemeralDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Normalize SCRIPT_NAME and PHP_SELF so CodeIgniter 4 treats root URL properly
if (isset($_SERVER['SCRIPT_NAME'])) {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
}
if (isset($_SERVER['PHP_SELF'])) {
    $_SERVER['PHP_SELF'] = '/index.php';
}

// Ensure working directory is resolved to public directory
chdir(__DIR__ . '/../public');

// Require the main application front controller
require __DIR__ . '/../public/index.php';
