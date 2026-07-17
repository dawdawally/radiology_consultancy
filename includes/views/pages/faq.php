<?php $page = getPageContent('faq'); ?>
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= e($page['breadcrumb_label'] ?? 'FAQ') ?></li>
            </ol>
        </nav>
        <h1 data-aos="fade-up"><?= e($page['hero_title'] ?? 'Frequently Asked Questions') ?></h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e($page['hero_subtitle'] ?? '') ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9" data-aos="fade-up">
                <?php if (empty($faqs)): ?>
                <p class="text-muted text-center">No FAQs are available at the moment. Please <a href="<?= url('contact') ?>">contact us</a> with your question.</p>
                <?php else: ?>
                <div class="accordion faq-accordion" id="faqAccordion">
                    <?php foreach ($faqs as $i => $faq): ?>
                    <?php $collapseId = 'faq-' . (int) $faq['id']; ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?= $collapseId ?>">
                            <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="<?= $collapseId ?>">
                                <?= e($faq['question']) ?>
                            </button>
                        </h2>
                        <div id="<?= $collapseId ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" aria-labelledby="heading-<?= $collapseId ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body faq-answer">
                                <?= $faq['answer'] ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($page['cta_title'])): ?>
                <div class="text-center mt-5 p-4 bg-light rounded-4">
                    <h4 class="mb-2"><?= e($page['cta_title']) ?></h4>
                    <?php if (!empty($page['cta_subtitle'])): ?>
                    <p class="text-muted mb-3"><?= e($page['cta_subtitle']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($page['cta_button_text'])): ?>
                    <a href="<?= linkUrl($page['cta_button_url'] ?? 'contact') ?>" class="btn btn-primary rounded-pill px-4"><?= e($page['cta_button_text']) ?></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
