<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= url('blog') ?>">Resources</a></li>
                <li class="breadcrumb-item active"><?= e(truncate($post['title'], 50)) ?></li>
            </ol>
        </nav>
        <?php if ($post['category_name']): ?>
        <span class="blog-category mb-2 d-inline-block"><?= e($post['category_name']) ?></span>
        <?php endif; ?>
        <h1 data-aos="fade-up"><?= e($post['title']) ?></h1>
        <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Published <?= formatDate($post['published_at']) ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if ($post['excerpt']): ?>
                <p class="lead text-secondary mb-4" data-aos="fade-up"><?= e($post['excerpt']) ?></p>
                <?php endif; ?>
                <div class="blog-content" data-aos="fade-up"><?= $post['content'] ?? '' ?></div>
                <hr class="my-5">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= url('blog') ?>" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Back to Resources</a>
                    <a href="<?= url('contact') ?>" class="btn btn-primary rounded-pill">Discuss This Topic</a>
                </div>
            </div>
        </div>
    </div>
</section>
