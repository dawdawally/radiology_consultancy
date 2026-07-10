<?php
/**
 * Copy this file to config.local.php for local XAMPP development.
 *
 * Production uses config.production.php on the server (see DEPLOY.md).
 * config.php auto-loads the correct file based on the domain.
 */
return [
    'app_name' => 'Radiation Equipment Consultancy',
    'app_url' => 'http://localhost/biomedical_consultancy',
    'debug' => true,

    'db' => [
        'host' => 'localhost',
        'port' => '3306',
        'name' => 'medrad_consultancy',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],

    'mail' => [
        'from_email' => 'noreply@radiationequipmentconsultancy.com',
        'from_name' => 'Radiation Equipment Consultancy',
        'admin_email' => 'info@radiationequipmentconsultancy.com',
    ],

    'upload' => [
        'max_size' => 5242880,
        'allowed_types' => ['image/jpeg', 'image/png', 'image/webp'],
        'path' => __DIR__ . '/../../uploads/',
    ],

    'session' => [
        'name' => 'REC_SESSION',
        'lifetime' => 7200,
    ],
];
