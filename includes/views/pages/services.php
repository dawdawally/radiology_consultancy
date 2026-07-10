<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active">Services</li>
            </ol>
        </nav>
        <h1 data-aos="fade-up">Our Consultancy Services</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">End-to-end support for radiation equipment — from planning and installation to commissioning, training, and ongoing compliance.</p>
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

<section class="cta-section py-5">
    <div class="container text-center">
        <h2 class="text-white mb-3">Not Sure Which Service You Need?</h2>
        <p class="text-white-50 mb-4">We will help you define scope and deliver a tailored proposal.</p>
        <a href="<?= url('contact') ?>" class="btn btn-light btn-lg rounded-pill px-5">Speak With Our Team</a>
    </div>
</section>
