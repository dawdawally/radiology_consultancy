<?php
$approach = parseJsonField($service['approach'] ?? null);
$deliverables = parseJsonField($service['deliverables'] ?? null);
$page = getPageContent('service_detail');
$extra = $page['extra'] ?? [];
$related = array_slice(array_filter($relatedServices ?? [], static fn($s) => ($s['slug'] ?? '') !== ($service['slug'] ?? '')), 0, 3);
?>

<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= url('services') ?>"><?= e($page['breadcrumb_label'] ?? 'Services') ?></a></li>
                <li class="breadcrumb-item active"><?= e($service['title']) ?></li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3 mb-3" data-aos="fade-up">
            <div class="service-hero-icon"><i class="fa-solid <?= e($service['icon']) ?>"></i></div>
            <h1 class="mb-0"><?= e($service['title']) ?></h1>
        </div>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e($service['short_description']) ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="content-block mb-5" data-aos="fade-up">
                    <h2><?= e($extra['overview_heading'] ?? 'Overview') ?></h2>
                    <div class="text-secondary"><?= $service['intro'] ?? '' ?></div>
                </div>

                <div class="content-block mb-5" data-aos="fade-up">
                    <h2><?= e($extra['challenge_heading'] ?? 'The Challenge') ?></h2>
                    <div class="challenge-box"><?= $service['challenge'] ?? '' ?></div>
                </div>

                <div class="content-block mb-5" data-aos="fade-up">
                    <h2><?= e($extra['approach_heading'] ?? 'Our Approach') ?></h2>
                    <div class="approach-steps">
                        <?php foreach ($approach as $i => $step): ?>
                        <div class="approach-step">
                            <div class="step-badge"><?= e($step['step'] ?? (string)($i + 1)) ?></div>
                            <div>
                                <h5><?= e($step['title'] ?? '') ?></h5>
                                <p><?= e($step['description'] ?? '') ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (!empty($deliverables)): ?>
                <div class="content-block mb-5" data-aos="fade-up">
                    <h2><?= e($extra['deliverables_heading'] ?? 'Deliverables') ?></h2>
                    <ul class="deliverables-list">
                        <?php foreach ($deliverables as $item): ?>
                        <li><i class="fa-solid fa-circle-check text-primary me-2"></i><?= e(is_string($item) ? $item : ($item['title'] ?? '')) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($service['benefits'])): ?>
                <div class="content-block" data-aos="fade-up">
                    <h2><?= e($extra['benefits_heading'] ?? 'Benefits for Your Facility') ?></h2>
                    <div class="text-secondary"><?= $service['benefits'] ?? '' ?></div>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-card sticky-top" style="top: 100px;" data-aos="fade-left">
                    <h4><?= e($page['cta_title'] ?? 'Request a Consultation') ?></h4>
                    <p class="text-muted"><?= e($page['cta_subtitle'] ?? '') ?></p>
                    <a href="<?= linkUrl(($page['cta_button_url'] ?? 'contact') . '?subject=' . urlencode($service['title'])) ?>" class="btn btn-primary w-100 rounded-pill mb-3"><?= e($page['cta_button_text'] ?? 'Get in Touch') ?></a>
                    <?php if (!empty($related)): ?>
                    <hr>
                    <h6><?= e($extra['related_heading'] ?? 'Related Services') ?></h6>
                    <ul class="related-links list-unstyled">
                        <?php foreach ($related as $rel): ?>
                        <li><a href="<?= url('services/' . $rel['slug']) ?>"><?= e($rel['title']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
