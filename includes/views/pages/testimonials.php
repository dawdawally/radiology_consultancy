<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active">Case Studies</li>
            </ol>
        </nav>
        <h1 data-aos="fade-up">Case Studies & Testimonials</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Measurable outcomes from radiation equipment projects we have delivered worldwide.</p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($testimonials as $i => $t): ?>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= ($i % 2) * 100 ?>">
                <div class="testimonial-card h-100 p-4">
                    <div class="stars mb-3"><?php for ($s = 0; $s < ($t['rating'] ?? 5); $s++): ?><i class="fa-solid fa-star"></i><?php endfor; ?></div>
                    <p class="testimonial-text fs-5">"<?= e($t['content']) ?>"</p>
                    <?php if ($t['outcome_metric']): ?>
                    <div class="outcome-badge my-3"><i class="fa-solid fa-chart-line me-2"></i><?= e($t['outcome_metric']) ?></div>
                    <?php endif; ?>
                    <div class="testimonial-author mt-4 pt-3 border-top">
                        <strong><?= e($t['client_name']) ?></strong>
                        <small class="d-block text-muted"><?= e($t['role']) ?>, <?= e($t['organization']) ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section py-5">
    <div class="container text-center">
        <h2 class="text-white mb-3">Ready to Achieve Similar Results?</h2>
        <a href="<?= url('contact') ?>" class="btn btn-light btn-lg rounded-pill px-5">Start Your Project</a>
    </div>
</section>
