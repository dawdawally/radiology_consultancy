<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active">Equipment Expertise</li>
            </ol>
        </nav>
        <h1 data-aos="fade-up">Equipment Expertise</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">We provide hands-on consultancy across radiotherapy, diagnostic radiology, and nuclear medicine modalities worldwide.</p>
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

<section class="cta-section py-5">
    <div class="container text-center">
        <h2 class="text-white mb-3">Need Support With Your Equipment?</h2>
        <p class="text-white-50 mb-4">We support installations, commissioning, and compliance across all listed modalities.</p>
        <a href="<?= url('contact') ?>" class="btn btn-light btn-lg rounded-pill px-5">Discuss Your Project</a>
    </div>
</section>
