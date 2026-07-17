<?php $page = getPageContent('equipment'); ?>
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= e($page['breadcrumb_label'] ?? 'Equipment Expertise') ?></li>
            </ol>
        </nav>
        <h1 data-aos="fade-up"><?= e($page['hero_title'] ?? 'Equipment Expertise') ?></h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e($page['hero_subtitle'] ?? '') ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <?php foreach ($equipment as $category => $items): ?>
        <div class="equipment-category mb-5" data-aos="fade-up">
            <div class="category-header">
                <h2><?= e($category) ?></h2>
                <div class="category-line"></div>
            </div>
            <div class="row g-4 mt-2">
                <?php foreach ($items as $item): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="equipment-detail-card h-100">
                        <div class="eq-icon"><i class="fa-solid <?= e($item['icon']) ?>"></i></div>
                        <h5><?= e($item['name']) ?></h5>
                        <p><?= e($item['description']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
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
