<?php $page = getPageContent('services'); ?>
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= e($page['breadcrumb_label'] ?? 'Services') ?></li>
            </ol>
        </nav>
        <h1 data-aos="fade-up"><?= e($page['hero_title'] ?? 'Our Consultancy Services') ?></h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e($page['hero_subtitle'] ?? '') ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($services as $i => $service): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="service-card h-100">
                    <div class="service-icon"><i class="fa-solid <?= e($service['icon']) ?>"></i></div>
                    <h5><?= e($service['title']) ?></h5>
                    <p><?= e($service['short_description']) ?></p>
                    <a href="<?= url('services/' . $service['slug']) ?>" class="service-link">View details <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($page['cta_title'])): ?>
<section class="cta-section py-5">
    <div class="container text-center">
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
