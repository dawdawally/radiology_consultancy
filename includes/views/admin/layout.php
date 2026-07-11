<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageHeading ?? 'Admin') ?> | <?= e(getSetting('site_name')) ?></title>
    <?php require INCLUDES_PATH . '/views/partials/favicon.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('css/admin.css') ?>" rel="stylesheet">
</head>
<body class="admin-body">
<div class="admin-wrapper">
    <?php require INCLUDES_PATH . '/views/admin/partials/sidebar.php'; ?>
    <div class="admin-main">
        <?php require INCLUDES_PATH . '/views/admin/partials/topbar.php'; ?>
        <div class="admin-content">
            <?php if ($flash = getFlash()): ?>
            <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert">
                <?= e($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="<?= asset('js/admin.js') ?>" defer></script>
</body>
</html>
