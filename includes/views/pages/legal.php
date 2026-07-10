<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= e($title) ?></li>
            </ol>
        </nav>
        <h1 data-aos="fade-up"><?= e($title) ?></h1>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="legal-content" data-aos="fade-up"><?= $content ?></div>
            </div>
        </div>
    </div>
</section>
