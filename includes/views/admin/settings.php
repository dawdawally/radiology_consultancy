<div class="admin-card">
    <form method="POST" action="<?= adminUrl('page=settings') ?>">
        <?= csrfField() ?>
        <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">General</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact" type="button">Contact</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#legal" type="button">Legal</button></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="general">
                <div class="mb-3"><label class="form-label">Site Name</label><input type="text" name="site_name" class="form-control" value="<?= e($settings['site_name'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Tagline</label><input type="text" name="tagline" class="form-control" value="<?= e($settings['tagline'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Footer Text</label><textarea name="footer_text" class="form-control" rows="3"><?= e($settings['footer_text'] ?? '') ?></textarea></div>
                <div class="mb-3"><label class="form-label">LinkedIn URL</label><input type="url" name="linkedin" class="form-control" value="<?= e($settings['linkedin'] ?? '') ?>"></div>
            </div>
            <div class="tab-pane fade" id="contact">
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= e($settings['email'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="<?= e($settings['phone'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2"><?= e($settings['address'] ?? '') ?></textarea></div>
                <div class="mb-3"><label class="form-label">Response Time Message</label><input type="text" name="response_time" class="form-control" value="<?= e($settings['response_time'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Contact Page Intro (HTML)</label><textarea name="contact_intro" class="form-control" rows="4"><?= e($settings['contact_intro'] ?? '') ?></textarea></div>
            </div>
            <div class="tab-pane fade" id="legal">
                <div class="mb-3"><label class="form-label">Privacy Policy (HTML)</label><textarea name="privacy_content" class="form-control" rows="10"><?= e($settings['privacy_content'] ?? '') ?></textarea></div>
                <div class="mb-3"><label class="form-label">Terms of Use (HTML)</label><textarea name="terms_content" class="form-control" rows="10"><?= e($settings['terms_content'] ?? '') ?></textarea></div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
    </form>
</div>
