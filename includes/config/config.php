<?php
/**
 * Environment router — loads the correct config file.
 * Do not put credentials in this file.
 */
declare(strict_types=1);

$isProduction = isProductionEnvironment();

$configFile = $isProduction
    ? __DIR__ . '/config.production.php'
    : __DIR__ . '/config.local.php';

if (!file_exists($configFile)) {
    $template = $isProduction
        ? 'config.production.php (create on server — see DEPLOY.md)'
        : 'config.local.php (copy from config.example.php)';
    die('Configuration missing: ' . basename($configFile) . '. Create from ' . $template);
}

return require $configFile;

function isProductionEnvironment(): bool
{
    if (getenv('APP_ENV') === 'production') {
        return true;
    }
    if (getenv('APP_ENV') === 'local') {
        return false;
    }

    $host = strtolower($_SERVER['HTTP_HOST'] ?? '');

    return str_contains($host, 'radiationequipmentconsultancy.com');
}
