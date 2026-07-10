<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </nav>
        <h1 data-aos="fade-up">Contact Us</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100"><?= e(getSetting('response_time')) ?></p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info-card">
                    <h3>Get in Touch</h3>
                    <?= getSetting('contact_intro') ?>
                    <ul class="contact-details list-unstyled mt-4">
                        <li><i class="fa-solid fa-envelope"></i><div><strong>Email</strong><br><a href="mailto:<?= e(getSetting('email')) ?>"><?= e(getSetting('email')) ?></a></div></li>
                        <li><i class="fa-solid fa-phone"></i><div><strong>Phone</strong><br><?= e(getSetting('phone')) ?></div></li>
                        <li><i class="fa-solid fa-location-dot"></i><div><strong>Address</strong><br><?= e(getSetting('address')) ?></div></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form-card">
                    <h3>Send Us a Message</h3>
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
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" value="<?= old('subject', $_GET['subject'] ?? '') ?>">
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
