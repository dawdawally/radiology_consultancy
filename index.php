<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$route = trim($_GET['route'] ?? 'home', '/');
$controller = new PublicController();
$controller->dispatch($route);
