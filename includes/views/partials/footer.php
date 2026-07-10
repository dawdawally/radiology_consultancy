<footer class="site-footer">
    <div class="container">
        <div class="row g-4 py-5">
            <div class="col-lg-4">
                <div class="footer-brand mb-3">
                    <a href="<?= url() ?>">
                        <img src="<?= logoUrl() ?>" alt="<?= e(getSetting('site_name')) ?>" class="footer-logo">
                    </a>
                </div>
                <p class="text-white-50"><?= e(getSetting('footer_text')) ?></p>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-heading">Quick Links</h6>
                <ul class="footer-links">
                    <li><a href="<?= url('about') ?>">About Us</a></li>
                    <li><a href="<?= url('services') ?>">Services</a></li>
                    <li><a href="<?= url('equipment') ?>">Equipment</a></li>
                    <li><a href="<?= url('blog') ?>">Resources</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-heading">Services</h6>
                <ul class="footer-links">
                    <li><a href="<?= url('services/installation-services') ?>">Installation</a></li>
                    <li><a href="<?= url('services/commissioning-acceptance-testing') ?>">Commissioning</a></li>
                    <li><a href="<?= url('services/staff-training') ?>">Staff Training</a></li>
                    <li><a href="<?= url('services/radiation-safety-compliance') ?>">Radiation Safety</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="footer-heading">Contact</h6>
                <ul class="footer-contact list-unstyled text-white-50">
                    <li><i class="fa-solid fa-envelope me-2"></i><a href="mailto:<?= e(getSetting('email')) ?>"><?= e(getSetting('email')) ?></a></li>
                    <li><i class="fa-solid fa-phone me-2"></i><?= e(getSetting('phone')) ?></li>
                    <li><i class="fa-solid fa-location-dot me-2"></i><?= e(getSetting('address')) ?></li>
                </ul>
                <?php if ($linkedin = getSetting('linkedin')): ?>
                <a href="<?= e($linkedin) ?>" class="social-link" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center py-3 border-top border-secondary">
            <span>&copy; <?= date('Y') ?> <?= e(getSetting('site_name')) ?>. All rights reserved.</span>
            <div class="footer-legal">
                <a href="<?= url('privacy') ?>">Privacy Policy</a>
                <span class="mx-2">|</span>
                <a href="<?= url('terms') ?>">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>
