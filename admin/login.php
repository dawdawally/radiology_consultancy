<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf($_POST['csrf_token'] ?? '')) {
        setFlash('danger', 'Invalid request.');
        redirect(url('admin/login.php'));
    }
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (attemptLogin($username, $password)) {
        redirect(adminUrl());
    }
    setFlash('danger', 'Invalid username or password.');
}

if (isLoggedIn()) {
    redirect(adminUrl());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= e(getSetting('site_name', config('app_name', 'MedRad'))) ?></title>
    <?php require INCLUDES_PATH . '/views/partials/favicon.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('css/admin.css') ?>" rel="stylesheet">
</head>
<body class="login-page">
<div class="login-card">
    <div class="text-center mb-4">
        <img src="<?= logoUrl() ?>" alt="<?= e(getSetting('site_name', 'Radiation Medical Consultancy')) ?>" class="login-logo mb-3">
        <h4>Admin Dashboard</h4>
        <p class="text-muted small"><?= e(getSetting('site_name', config('app_name', 'MedRad Technical Consultancy'))) ?></p>
    </div>
    <?php if ($flash = getFlash()): ?>
    <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endif; ?>
    <form method="POST">
        <?= csrfField() ?>
        <div class="mb-3">
            <label class="form-label">Username or Email</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign In</button>
    </form>
    <div class="text-center mt-3">
        <a href="<?= url() ?>" class="small text-muted"><i class="fa-solid fa-arrow-left me-1"></i>Back to website</a>
    </div>
</div>
</body>
</html>
