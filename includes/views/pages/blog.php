<?php
$page = getPageContent('blog');
$extra = $page['extra'] ?? [];
?>
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= e($page['breadcrumb_label'] ?? 'Resources') ?></li>
            </ol>
        </nav>
        <h1 data-aos="fade-up"><?= e($page['hero_title'] ?? 'Resources & Insights') ?></h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e($page['hero_subtitle'] ?? '') ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <?php if (empty($posts)): ?>
        <div class="text-center py-5">
            <p class="text-muted"><?= e($extra['empty_message'] ?? 'New articles will be published soon. Check back for expert insights on radiation equipment.') ?></p>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($posts as $i => $post): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <article class="blog-card h-100">
                    <div class="blog-card-body">
                        <?php if ($post['category_name']): ?>
                        <span class="blog-category"><?= e($post['category_name']) ?></span>
                        <?php endif; ?>
                        <h5><a href="<?= url('blog/' . $post['slug']) ?>"><?= e($post['title']) ?></a></h5>
                        <p><?= e(truncate(strip_tags($post['excerpt'] ?? ''), 140)) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><?= formatDate($post['published_at']) ?></small>
                            <a href="<?= url('blog/' . $post['slug']) ?>" class="service-link">Read more</a>
                        </div>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
