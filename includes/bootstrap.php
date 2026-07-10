<?php
/**
 * Application bootstrap — loaded by all entry points.
 */

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes');

$configFile = INCLUDES_PATH . '/config/config.php';
if (!file_exists($configFile)) {
    die('Configuration missing. Copy includes/config/config.example.php to config.php');
}

$GLOBALS['app_config'] = require $configFile;

require_once INCLUDES_PATH . '/functions.php';
require_once INCLUDES_PATH . '/db.php';
require_once INCLUDES_PATH . '/auth.php';

spl_autoload_register(function (string $class): void {
    $paths = [
        INCLUDES_PATH . '/models/' . $class . '.php',
        INCLUDES_PATH . '/controllers/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

if (session_status() === PHP_SESSION_NONE) {
    $sessionName = config('session.name', 'MEDRAD_SESSION');
    session_name($sessionName);
    session_start();
}
