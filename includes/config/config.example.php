<?php
/**
 * Copy this file to config.php and update values for your environment.
 */
return [
    'app_name' => 'MedRad Technical Consultancy',
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
        'from_email' => 'noreply@medradconsultancy.com',
        'from_name' => 'MedRad Technical Consultancy',
        'admin_email' => 'info@medradconsultancy.com',
    ],

    'upload' => [
        'max_size' => 5242880, // 5MB
        'allowed_types' => ['image/jpeg', 'image/png', 'image/webp'],
        'path' => __DIR__ . '/../../uploads/',
    ],

    'session' => [
        'name' => 'MEDRAD_SESSION',
        'lifetime' => 7200,
    ],
];
