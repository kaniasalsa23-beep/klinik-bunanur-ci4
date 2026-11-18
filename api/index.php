<?php

/**
 * Vercel Serverless PHP Bridge for CodeIgniter 4
 *
 * This bridge captures serverless HTTP invocations from Vercel and forwards them
 * directly to the CodeIgniter 4 front controller in /public/index.php.
 */

// Normalize SCRIPT_NAME and PHP_SELF so CodeIgniter 4 handles root URLs and routes correctly
if (isset($_SERVER['SCRIPT_NAME'])) {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
}
if (isset($_SERVER['PHP_SELF'])) {
    $_SERVER['PHP_SELF'] = '/index.php';
}

// Ensure working directory is set to the public directory
chdir(__DIR__ . '/../public');

// Forward to public front controller
require __DIR__ . '/../public/index.php';
