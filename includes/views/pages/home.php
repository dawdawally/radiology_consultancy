<?php
$hero = $sections['hero'] ?? [];
$aboutPreview = $sections['about_preview'] ?? [];
$servicesIntro = $sections['services_intro'] ?? [];
$equipmentIntro = $sections['equipment_intro'] ?? [];
$whyChoose = $sections['why_choose_us'] ?? [];
$process = $sections['process'] ?? [];
$testimonialsIntro = $sections['testimonials_intro'] ?? [];
$blogIntro = $sections['blog_intro'] ?? [];
$cta = $sections['cta'] ?? [];

$heroExtra = sectionExtra($hero);
$aboutExtra = sectionExtra($aboutPreview);
$servicesExtra = sectionExtra($servicesIntro);
$equipmentExtra = sectionExtra($equipmentIntro);
$whyExtra = sectionExtra($whyChoose);
$processExtra = sectionExtra($process);
$testimonialsExtra = sectionExtra($testimonialsIntro);
$blogExtra = sectionExtra($blogIntro);

$stats = $heroExtra['stats'] ?? [];
$features = $aboutExtra['features'] ?? [];
$whyItems = $whyExtra['items'] ?? [];
$processItems = $processExtra['items'] ?? [];
$servicesCount = (int) ($servicesCount ?? 0);

// Specialist service count always comes from published services (not admin-entered)
foreach ($stats as &$stat) {
    $source = $stat['source'] ?? '';
    $label = $stat['label'] ?? '';
    if ($source === 'services_count' || stripos($label, 'Specialist Service') !== false) {
        $stat['value'] = (string) $servicesCount;
        $stat['source'] = 'services_count';
        if ($label === '') {
            $stat['label'] = 'Specialist Service Areas';
        }
    }
}
unset($stat);
?>

<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-7" data-aos="fade-up">
                <?php if (!empty($heroExtra['badge'])): ?>
                <span class="hero-badge"><?= e($heroExtra['badge']) ?></span>
                <?php endif; ?>
                <h1 class="hero-title"><?= e($hero['title'] ?? '') ?></h1>
                <p class="hero-subtitle"><?= e($hero['subtitle'] ?? '') ?></p>
                <div class="hero-content text-white-50 mb-4"><?= $hero['content'] ?? '' ?></div>
                <?php if (!empty($hero['button_text'])): ?>
                <a href="<?= linkUrl($hero['button_url']) ?>" class="btn btn-light btn-lg rounded-pill px-4 me-2"><?= e($hero['button_text']) ?></a>
                <?php endif; ?>
                <?php if (!empty($heroExtra['button2_text'])): ?>
                <a href="<?= linkUrl($heroExtra['button2_url'] ?? 'services') ?>" class="btn btn-outline-light btn-lg rounded-pill px-4"><?= e($heroExtra['button2_text']) ?></a>
                <?php endif; ?>
            </div>
            <?php if (!empty($stats)): ?>
            <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left">
                <div class="hero-stats-card">
                    <?php foreach ($stats as $stat): ?>
                    <div class="stat-item"><strong><?= e($stat['value'] ?? '') ?></strong><span><?= e($stat['label'] ?? '') ?></span></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <?php if (!empty($aboutExtra['section_label'])): ?><span class="section-label"><?= e($aboutExtra['section_label']) ?></span><?php endif; ?>
                <h2 class="section-title"><?= e($aboutPreview['title'] ?? '') ?></h2>
                <p class="text-muted lead"><?= e($aboutPreview['subtitle'] ?? '') ?></p>
                <div class="text-secondary"><?= $aboutPreview['content'] ?? '' ?></div>
                <?php if (!empty($aboutPreview['button_text'])): ?>
                <a href="<?= linkUrl($aboutPreview['button_url']) ?>" class="btn btn-primary rounded-pill mt-3"><?= e($aboutPreview['button_text']) ?></a>
                <?php endif; ?>
            </div>
            <?php if (!empty($features)): ?>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="feature-grid">
                    <?php foreach ($features as $feature): ?>
                    <div class="feature-box">
                        <i class="fa-solid <?= e($feature['icon'] ?? 'fa-check') ?>"></i>
                        <h5><?= e($feature['title'] ?? '') ?></h5>
                        <p><?= e($feature['description'] ?? '') ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (!empty($servicesExtra['section_label'])): ?><span class="section-label"><?= e($servicesExtra['section_label']) ?></span><?php endif; ?>
            <h2 class="section-title"><?= e($servicesIntro['title'] ?? '') ?></h2>
            <p class="text-muted mx-auto section-lead"><?= e($servicesIntro['subtitle'] ?? '') ?></p>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $i => $service): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                <div class="service-card h-100">
                    <div class="service-icon"><i class="fa-solid <?= e($service['icon']) ?>"></i></div>
                    <h5><?= e($service['title']) ?></h5>
                    <p><?= e(truncate($service['short_description'], 120)) ?></p>
                    <a href="<?= url('services/' . $service['slug']) ?>" class="service-link">Learn more <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="<?= linkUrl($servicesIntro['button_url'] ?? 'services') ?>" class="btn btn-outline-primary rounded-pill px-4"><?= e($servicesIntro['button_text'] ?? 'View All Services') ?></a>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (!empty($equipmentExtra['section_label'])): ?><span class="section-label"><?= e($equipmentExtra['section_label']) ?></span><?php endif; ?>
            <h2 class="section-title"><?= e($equipmentIntro['title'] ?? '') ?></h2>
            <p class="text-muted mx-auto section-lead"><?= e($equipmentIntro['subtitle'] ?? '') ?></p>
        </div>
        <div class="row g-4">
            <?php $catIndex = 0; foreach ($equipment as $category => $items): ?>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?= $catIndex * 100 ?>">
                <div class="equipment-card h-100">
                    <h5><?= e($category) ?></h5>
                    <ul class="equipment-list">
                        <?php foreach (array_slice($items, 0, 4) as $item): ?>
                        <li><i class="fa-solid <?= e($item['icon']) ?> me-2 text-primary"></i><?= e($item['name']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php $catIndex++; endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= linkUrl($equipmentIntro['button_url'] ?? 'equipment') ?>" class="btn btn-primary rounded-pill px-4"><?= e($equipmentIntro['button_text'] ?? 'View All Equipment') ?></a>
        </div>
    </div>
</section>

<section class="section-padding bg-primary-soft">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (!empty($whyExtra['section_label'])): ?><span class="section-label"><?= e($whyExtra['section_label']) ?></span><?php endif; ?>
            <h2 class="section-title"><?= e($whyChoose['title'] ?? '') ?></h2>
            <p class="text-muted mx-auto section-lead"><?= e($whyChoose['subtitle'] ?? '') ?></p>
        </div>
        <div class="row g-4">
            <?php foreach ($whyItems as $i => $item): ?>
            <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="why-card h-100">
                    <div class="why-icon"><i class="fa-solid <?= e($item['icon'] ?? 'fa-check') ?>"></i></div>
                    <h5><?= e($item['title'] ?? '') ?></h5>
                    <p><?= e($item['description'] ?? '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (!empty($processExtra['section_label'])): ?><span class="section-label"><?= e($processExtra['section_label']) ?></span><?php endif; ?>
            <h2 class="section-title"><?= e($process['title'] ?? '') ?></h2>
            <p class="text-muted mx-auto section-lead"><?= e($process['subtitle'] ?? '') ?></p>
        </div>
        <div class="process-timeline">
            <?php foreach ($processItems as $i => $item): ?>
            <div class="process-step" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="process-number"><?= $i + 1 ?></div>
                <div class="process-content">
                    <h5><?= e($item['title'] ?? '') ?></h5>
                    <p><?= e($item['description'] ?? '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($testimonials)): ?>
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (!empty($testimonialsExtra['section_label'])): ?><span class="section-label"><?= e($testimonialsExtra['section_label']) ?></span><?php endif; ?>
            <h2 class="section-title"><?= e($testimonialsIntro['title'] ?? 'What Our Clients Say') ?></h2>
            <?php if (!empty($testimonialsIntro['subtitle'])): ?>
            <p class="text-muted mx-auto section-lead"><?= e($testimonialsIntro['subtitle']) ?></p>
            <?php endif; ?>
        </div>
        <div class="row g-4">
            <?php foreach ($testimonials as $i => $t): ?>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="testimonial-card h-100">
                    <div class="stars mb-3"><?php for ($s = 0; $s < ($t['rating'] ?? 5); $s++): ?><i class="fa-solid fa-star"></i><?php endfor; ?></div>
                    <p class="testimonial-text">"<?= e($t['content']) ?>"</p>
                    <?php if ($t['outcome_metric']): ?><span class="badge bg-primary-subtle text-primary mb-3"><?= e($t['outcome_metric']) ?></span><?php endif; ?>
                    <div class="testimonial-author">
                        <strong><?= e($t['client_name']) ?></strong>
                        <small><?= e($t['role']) ?>, <?= e($t['organization']) ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($testimonialsIntro['button_text'])): ?>
        <div class="text-center mt-4"><a href="<?= linkUrl($testimonialsIntro['button_url'] ?? 'testimonials') ?>" class="btn btn-outline-primary rounded-pill"><?= e($testimonialsIntro['button_text']) ?></a></div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($posts)): ?>
<section class="section-padding bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <?php if (!empty($blogExtra['section_label'])): ?><span class="section-label"><?= e($blogExtra['section_label']) ?></span><?php endif; ?>
            <h2 class="section-title"><?= e($blogIntro['title'] ?? 'Latest Insights') ?></h2>
            <?php if (!empty($blogIntro['subtitle'])): ?>
            <p class="text-muted mx-auto section-lead"><?= e($blogIntro['subtitle']) ?></p>
            <?php endif; ?>
        </div>
        <div class="row g-4">
            <?php foreach ($posts as $i => $post): ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <article class="blog-card h-100">
                    <div class="blog-card-body">
                        <?php if ($post['category_name']): ?><span class="blog-category"><?= e($post['category_name']) ?></span><?php endif; ?>
                        <h5><a href="<?= url('blog/' . $post['slug']) ?>"><?= e($post['title']) ?></a></h5>
                        <p><?= e(truncate(strip_tags($post['excerpt'] ?? ''), 120)) ?></p>
                        <small class="text-muted"><?= formatDate($post['published_at']) ?></small>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($blogIntro['button_text'])): ?>
        <div class="text-center mt-4"><a href="<?= linkUrl($blogIntro['button_url'] ?? 'blog') ?>" class="btn btn-outline-primary rounded-pill"><?= e($blogIntro['button_text']) ?></a></div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<section class="cta-section">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="text-white mb-3"><?= e($cta['title'] ?? 'Ready to Get Started?') ?></h2>
        <p class="text-white-50 mb-4 mx-auto cta-lead"><?= e($cta['subtitle'] ?? '') ?></p>
        <a href="<?= linkUrl($cta['button_url'] ?? 'contact') ?>" class="btn btn-light btn-lg rounded-pill px-5"><?= e($cta['button_text'] ?? 'Request a Consultation') ?></a>
    </div>
</section>
