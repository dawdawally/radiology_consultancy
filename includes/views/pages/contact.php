<?php
$page = getPageContent('contact');
$extra = $page['extra'] ?? [];
$heroSubtitle = trim($page['hero_subtitle'] ?? '') !== '' ? $page['hero_subtitle'] : getSetting('response_time');
?>
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= e($page['breadcrumb_label'] ?? 'Contact') ?></li>
            </ol>
        </nav>
        <h1 data-aos="fade-up"><?= e($page['hero_title'] ?? 'Contact Us') ?></h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e($heroSubtitle) ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info-card">
                    <h3><?= e($extra['sidebar_title'] ?? 'Get in Touch') ?></h3>
                    <?= getSetting('contact_intro') ?>
                    <ul class="contact-details list-unstyled mt-4">
                        <li><i class="fa-solid fa-envelope"></i><div><strong>Email</strong><br><a href="mailto:<?= e(getSetting('email')) ?>"><?= e(getSetting('email')) ?></a></div></li>
                        <li><i class="fa-solid fa-phone"></i><div><strong>Phone</strong><br><?= e(getSetting('phone')) ?></div></li>
                        <li><i class="fa-solid fa-location-dot"></i><div><strong>Address</strong><br><?= e(getSetting('address')) ?></div></li>
                    </ul>
                    <?php if (!empty($extra['faq_button_text'])): ?>
                    <div class="mt-4">
                        <a href="<?= url('faq') ?>" class="btn btn-outline-primary rounded-pill"><?= e($extra['faq_button_text']) ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form-card">
                    <h3><?= e($extra['form_title'] ?? 'Send Us a Message') ?></h3>
                    <form method="POST" action="<?= url('contact') ?>" class="needs-validation" novalidate>
                        <?= csrfField() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" value="<?= old('phone') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Topic *</label>
                                <?php $selectedTopic = old('topic', $_GET['topic'] ?? ''); ?>
                                <select name="topic" class="form-select" required id="contactTopic">
                                    <option value="" disabled <?= $selectedTopic === '' ? 'selected' : '' ?>>Select a topic</option>
                                    <optgroup label="Our Services">
                                        <?php foreach ($services as $service): ?>
                                        <option value="<?= e($service['slug']) ?>" <?= $selectedTopic === $service['slug'] ? 'selected' : '' ?>><?= e($service['title']) ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <option value="general-inquiry" <?= $selectedTopic === 'general-inquiry' ? 'selected' : '' ?>>General Inquiry</option>
                                    <option value="other" <?= $selectedTopic === 'other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-12" id="otherSubjectWrap" style="<?= $selectedTopic === 'other' ? '' : 'display:none;' ?>">
                                <label class="form-label">Please describe your topic *</label>
                                <input type="text" name="subject" id="contactSubject" class="form-control" value="<?= old('subject', $_GET['subject'] ?? '') ?>" placeholder="Brief description of your enquiry">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message *</label>
                                <textarea name="message" class="form-control" rows="6" required><?= old('message') ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
