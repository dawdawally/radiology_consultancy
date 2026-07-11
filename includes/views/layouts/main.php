<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? getSetting('site_name')) ?> | <?= e(getSetting('site_name')) ?></title>
    <?php require INCLUDES_PATH . '/views/partials/favicon.php'; ?>
    <?php if (!empty($metaDescription)): ?>
    <meta name="description" content="<?= e($metaDescription) ?>">
    <?php endif; ?>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"></noscript>
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
<?php require INCLUDES_PATH . '/views/partials/navbar.php'; ?>
<main>
    <?= $content ?>
</main>
<?php require INCLUDES_PATH . '/views/partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
