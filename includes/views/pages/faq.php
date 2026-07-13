<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active">FAQ</li>
            </ol>
        </nav>
        <h1 data-aos="fade-up">Frequently Asked Questions</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Answers to common questions about our radiation equipment consultancy services, process, and how we work with healthcare facilities.</p>
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

                <div class="text-center mt-5 p-4 bg-light rounded-4">
                    <h4 class="mb-2">Still have a question?</h4>
                    <p class="text-muted mb-3">Our team is ready to discuss your radiation equipment project.</p>
                    <a href="<?= url('contact') ?>" class="btn btn-primary rounded-pill px-4">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>
