<?php $flash = getFlash(); ?>
<nav class="navbar navbar-expand-lg navbar-light site-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= url() ?>">
            <img src="<?= logoUrl() ?>" alt="<?= e(getSetting('site_name', 'Radiation Medical Consultancy')) ?>" class="site-logo" width="160" height="48" decoding="async" fetchpriority="high">
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link <?= isActiveNav('home') ?>" href="<?= url() ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= isActiveNav('about') ?>" href="<?= url('about') ?>">About</a></li>
                <li class="nav-item"><a class="nav-link <?= isActiveNav('services') ?>" href="<?= url('services') ?>">Services</a></li>
                <li class="nav-item"><a class="nav-link <?= isActiveNav('equipment') ?>" href="<?= url('equipment') ?>">Equipment</a></li>
                <li class="nav-item"><a class="nav-link <?= isActiveNav('blog') ?>" href="<?= url('blog') ?>">Resources</a></li>
                <li class="nav-item"><a class="nav-link <?= isActiveNav('testimonials') ?>" href="<?= url('testimonials') ?>">Case Studies</a></li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-primary btn-sm px-3 rounded-pill" href="<?= url('contact') ?>">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php if ($flash): ?>
<div class="container mt-3">
    <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show shadow-sm" role="alert">
        <?= e($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php endif; ?>
