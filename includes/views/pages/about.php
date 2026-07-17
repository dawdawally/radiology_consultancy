<?php
$page = getPageContent('about');
$introExtra = sectionExtra($sections['intro'] ?? null);
$qualExtra = sectionExtra($sections['qualifications'] ?? null);
$certExtra = sectionExtra($sections['certifications'] ?? null);
$safetyExtra = sectionExtra($sections['safety_philosophy'] ?? null);
$teamExtra = sectionExtra($sections['team'] ?? null);
$heroTitle = trim($page['hero_title'] ?? '') !== '' ? $page['hero_title'] : ('About ' . getSetting('site_name'));
$heroSubtitle = trim($page['hero_subtitle'] ?? '') !== '' ? $page['hero_subtitle'] : getSetting('tagline');
?>
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= e($page['breadcrumb_label'] ?? 'About Us') ?></li>
            </ol>
        </nav>
        <h1 data-aos="fade-up"><?= e($heroTitle) ?></h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e($heroSubtitle) ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <?php if (!empty($introExtra['section_label'])): ?><span class="section-label"><?= e($introExtra['section_label']) ?></span><?php endif; ?>
                <h2 class="section-title"><?= e($sections['intro']['title'] ?? '') ?></h2>
                <div class="text-secondary"><?= $sections['intro']['content'] ?? '' ?></div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-image-placeholder">
                    <i class="fa-solid fa-users-gear"></i>
                    <p><?= e($introExtra['image_caption'] ?? 'Independent radiation equipment specialists') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($sections['qualifications'])): ?>
<section class="section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5" data-aos="fade-up">
                <?php if (!empty($qualExtra['section_label'])): ?><span class="section-label"><?= e($qualExtra['section_label']) ?></span><?php endif; ?>
                <h2 class="section-title"><?= e($sections['qualifications']['title']) ?></h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <div class="content-card"><?= $sections['qualifications']['content'] ?? '' ?></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($sections['certifications'])): ?>
<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5" data-aos="fade-right">
                <?php if (!empty($certExtra['section_label'])): ?><span class="section-label"><?= e($certExtra['section_label']) ?></span><?php endif; ?>
                <h2 class="section-title"><?= e($sections['certifications']['title']) ?></h2>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="content-card"><?= $sections['certifications']['content'] ?? '' ?></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($sections['safety_philosophy'])): ?>
<section class="section-padding bg-primary-soft">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center" data-aos="fade-up">
                <?php if (!empty($safetyExtra['section_label'])): ?><span class="section-label"><?= e($safetyExtra['section_label']) ?></span><?php endif; ?>
                <h2 class="section-title"><?= e($sections['safety_philosophy']['title']) ?></h2>
                <div class="text-secondary mt-4"><?= $sections['safety_philosophy']['content'] ?? '' ?></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($sections['team'])): ?>
<section class="section-padding bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-4" data-aos="fade-up">
                <?php if (!empty($teamExtra['section_label'])): ?><span class="section-label"><?= e($teamExtra['section_label']) ?></span><?php endif; ?>
                <h2 class="section-title"><?= e($sections['team']['title']) ?></h2>
            </div>
            <div class="col-lg-10" data-aos="fade-up">
                <div class="content-card"><?= $sections['team']['content'] ?? '' ?></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($page['cta_title'])): ?>
<section class="cta-section py-5">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="text-white mb-3"><?= e($page['cta_title']) ?></h2>
        <?php if (!empty($page['cta_subtitle'])): ?>
        <p class="text-white-50 mb-4"><?= e($page['cta_subtitle']) ?></p>
        <?php endif; ?>
        <?php if (!empty($page['cta_button_text'])): ?>
        <a href="<?= linkUrl($page['cta_button_url'] ?? 'contact') ?>" class="btn btn-light btn-lg rounded-pill px-5"><?= e($page['cta_button_text']) ?></a>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
