<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active">About Us</li>
            </ol>
        </nav>
        <h1 data-aos="fade-up">About <?= e(getSetting('site_name')) ?></h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e(getSetting('tagline')) ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-label">Who We Are</span>
                <h2 class="section-title"><?= e($sections['intro']['title'] ?? '') ?></h2>
                <div class="text-secondary"><?= $sections['intro']['content'] ?? '' ?></div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-image-placeholder">
                    <i class="fa-solid fa-users-gear"></i>
                    <p>Independent radiation equipment specialists</p>
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
                <span class="section-label">Expertise</span>
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
                <span class="section-label">Credentials</span>
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
                <span class="section-label">Our Philosophy</span>
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
                <span class="section-label">Our Team</span>
                <h2 class="section-title"><?= e($sections['team']['title']) ?></h2>
            </div>
            <div class="col-lg-10" data-aos="fade-up">
                <div class="content-card"><?= $sections['team']['content'] ?? '' ?></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="cta-section py-5">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="text-white mb-3">Partner With Us on Your Next Project</h2>
        <p class="text-white-50 mb-4">We bring the technical depth and regulatory knowledge your facility needs.</p>
        <a href="<?= url('contact') ?>" class="btn btn-light btn-lg rounded-pill px-5">Request a Consultation</a>
    </div>
</section>
