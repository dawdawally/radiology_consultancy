<?php
$hero = $sections['hero'] ?? [];
$aboutPreview = $sections['about_preview'] ?? [];
$servicesIntro = $sections['services_intro'] ?? [];
$equipmentIntro = $sections['equipment_intro'] ?? [];
$whyChoose = $sections['why_choose_us'] ?? [];
$process = $sections['process'] ?? [];
$cta = $sections['cta'] ?? [];
$whyItems = parseJsonField($whyChoose['extra_data'] ?? null);
$whyItems = $whyItems['items'] ?? $whyItems;
$processItems = parseJsonField($process['extra_data'] ?? null);
$processItems = $processItems['items'] ?? $processItems;
?>

<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-7" data-aos="fade-up">
                <span class="hero-badge">Radiation Equipment Consultancy</span>
                <h1 class="hero-title"><?= e($hero['title'] ?? '') ?></h1>
                <p class="hero-subtitle"><?= e($hero['subtitle'] ?? '') ?></p>
                <div class="hero-content text-white-50 mb-4"><?= $hero['content'] ?? '' ?></div>
                <?php if (!empty($hero['button_text'])): ?>
                <a href="<?= linkUrl($hero['button_url']) ?>" class="btn btn-light btn-lg rounded-pill px-4 me-2"><?= e($hero['button_text']) ?></a>
                <?php endif; ?>
                <a href="<?= url('services') ?>" class="btn btn-outline-light btn-lg rounded-pill px-4">Explore Services</a>
            </div>
            <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left">
                <div class="hero-stats-card">
                    <div class="stat-item"><strong>30+</strong><span>Years Combined Experience</span></div>
                    <div class="stat-item"><strong>11</strong><span>Specialist Service Areas</span></div>
                    <div class="stat-item"><strong>Global</strong><span>Project Delivery</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-label">About Us</span>
                <h2 class="section-title"><?= e($aboutPreview['title'] ?? '') ?></h2>
                <p class="text-muted lead"><?= e($aboutPreview['subtitle'] ?? '') ?></p>
                <div class="text-secondary"><?= $aboutPreview['content'] ?? '' ?></div>
                <?php if (!empty($aboutPreview['button_text'])): ?>
                <a href="<?= linkUrl($aboutPreview['button_url']) ?>" class="btn btn-primary rounded-pill mt-3"><?= e($aboutPreview['button_text']) ?></a>
                <?php endif; ?>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="feature-grid">
                    <div class="feature-box"><i class="fa-solid fa-shield-halved"></i><h5>Safety First</h5><p>Every engagement anchored in radiation safety and patient protection.</p></div>
                    <div class="feature-box"><i class="fa-solid fa-scale-balanced"></i><h5>Regulatory Expertise</h5><p>Deep knowledge of local and international regulatory frameworks.</p></div>
                    <div class="feature-box"><i class="fa-solid fa-microscope"></i><h5>Technical Authority</h5><p>Hands-on experience with complex radiation equipment worldwide.</p></div>
                    <div class="feature-box"><i class="fa-solid fa-handshake"></i><h5>Client Partnership</h5><p>We become your trusted advisor, not just a contractor.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Services</span>
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
            <span class="section-label">Equipment Expertise</span>
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
            <a href="<?= url('equipment') ?>" class="btn btn-primary rounded-pill px-4">View All Equipment</a>
        </div>
    </div>
</section>

<section class="section-padding bg-primary-soft">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Why Choose Us</span>
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
            <span class="section-label">Our Process</span>
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
            <span class="section-label">Client Success</span>
            <h2 class="section-title">What Our Clients Say</h2>
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
        <div class="text-center mt-4"><a href="<?= url('testimonials') ?>" class="btn btn-outline-primary rounded-pill">View Case Studies</a></div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($posts)): ?>
<section class="section-padding bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Resources</span>
            <h2 class="section-title">Latest Insights</h2>
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
