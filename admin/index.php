<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

$controller = new AdminController();
$controller->dispatch($page, $action);
