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
    $writable = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ci4_writable';
    $subdirs = ['', '/cache', '/logs', '/session', '/debugbar', '/uploads'];
    foreach ($subdirs as $sub) {
        $dir = $writable . $sub;
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
    }
    $paths->writableDirectory = $writable;
}

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';

exit(Boot::bootWeb($paths));
