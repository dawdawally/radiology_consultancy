<?php
$approach = parseJsonField($service['approach'] ?? null);
$deliverables = parseJsonField($service['deliverables'] ?? null);
?>

<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= url('services') ?>">Services</a></li>
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
                    <h2>Overview</h2>
                    <div class="text-secondary"><?= $service['intro'] ?? '' ?></div>
                </div>

                <div class="content-block mb-5" data-aos="fade-up">
                    <h2>The Challenge</h2>
                    <div class="challenge-box"><?= $service['challenge'] ?? '' ?></div>
                </div>

                <div class="content-block mb-5" data-aos="fade-up">
                    <h2>Our Approach</h2>
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
                    <h2>Deliverables</h2>
                    <ul class="deliverables-list">
                        <?php foreach ($deliverables as $item): ?>
                        <li><i class="fa-solid fa-circle-check text-primary me-2"></i><?= e(is_string($item) ? $item : ($item['title'] ?? '')) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($service['benefits'])): ?>
                <div class="content-block" data-aos="fade-up">
                    <h2>Benefits for Your Facility</h2>
                    <div class="text-secondary"><?= $service['benefits'] ?? '' ?></div>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-card sticky-top" style="top: 100px;" data-aos="fade-left">
                    <h4>Request a Consultation</h4>
                    <p class="text-muted">We will respond within one business day with practical next steps for your project.</p>
                    <a href="<?= url('contact') ?>?subject=<?= urlencode($service['title']) ?>" class="btn btn-primary w-100 rounded-pill mb-3">Get in Touch</a>
                    <hr>
                    <h6>Related Services</h6>
                    <ul class="related-links list-unstyled">
                        <li><a href="<?= url('services/installation-services') ?>">Installation Services</a></li>
                        <li><a href="<?= url('services/commissioning-acceptance-testing') ?>">Commissioning</a></li>
                        <li><a href="<?= url('services/radiation-safety-compliance') ?>">Radiation Safety</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
