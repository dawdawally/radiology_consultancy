<?php
$currentPage = $_GET['page'] ?? 'dashboard';
$navItems = [
    ['page' => 'dashboard', 'icon' => 'fa-gauge-high', 'label' => 'Dashboard'],
    ['page' => 'homepage', 'icon' => 'fa-house', 'label' => 'Homepage'],
    ['page' => 'about', 'icon' => 'fa-user-group', 'label' => 'About'],
    ['page' => 'services', 'icon' => 'fa-briefcase-medical', 'label' => 'Services'],
    ['page' => 'equipment', 'icon' => 'fa-microscope', 'label' => 'Equipment'],
    ['page' => 'blog', 'icon' => 'fa-newspaper', 'label' => 'Blog'],
    ['page' => 'testimonials', 'icon' => 'fa-quote-left', 'label' => 'Testimonials'],
    ['page' => 'faq', 'icon' => 'fa-circle-question', 'label' => 'FAQ'],
    ['page' => 'messages', 'icon' => 'fa-envelope', 'label' => 'Messages'],
    ['page' => 'media', 'icon' => 'fa-images', 'label' => 'Media'],
    ['page' => 'seo', 'icon' => 'fa-magnifying-glass', 'label' => 'SEO'],
    ['page' => 'settings', 'icon' => 'fa-gear', 'label' => 'Settings'],
    ['page' => 'profile', 'icon' => 'fa-user-shield', 'label' => 'Profile'],
];
?>
<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <img src="<?= logoUrl() ?>" alt="RMC Admin" class="sidebar-logo">
    </div>
    <nav class="sidebar-nav">
        <?php foreach ($navItems as $item): ?>
        <a href="<?= adminUrl('page=' . $item['page']) ?>" class="sidebar-link <?= $currentPage === $item['page'] ? 'active' : '' ?>">
            <i class="fa-solid <?= e($item['icon']) ?>"></i>
            <span><?= e($item['label']) ?></span>
        </a>
        <?php endforeach; ?>
    </nav>
    <div class="sidebar-footer">
        <a href="<?= url() ?>" target="_blank" class="sidebar-link"><i class="fa-solid fa-external-link"></i><span>View Site</span></a>
        <a href="<?= url('admin/logout.php') ?>" class="sidebar-link text-danger"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
    </div>
</aside>
