<?php
$pageLabels = [
    'about' => 'About',
    'services' => 'Services',
    'equipment' => 'Equipment',
    'testimonials' => 'Testimonials',
    'blog' => 'Blog / Resources',
    'faq' => 'FAQ',
    'contact' => 'Contact',
    'service_detail' => 'Service Detail Sidebar',
];
$key = $editPage['page_key'] ?? '';
$extra = parseJsonField($editPage['extra_data'] ?? null);
?>
<div class="row g-4">
    <div class="col-lg-3">
        <div class="admin-card p-0">
            <div class="list-group list-group-flush">
                <?php foreach ($pages as $page): ?>
                <a href="<?= adminUrl('page=pages&edit=' . e($page['page_key'])) ?>"
                   class="list-group-item list-group-item-action <?= $key === $page['page_key'] ? 'active' : '' ?>">
                    <?= e($pageLabels[$page['page_key']] ?? ucwords(str_replace('_', ' ', $page['page_key']))) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <?php if ($editPage): ?>
        <div class="admin-card">
            <h5 class="mb-3">Edit: <?= e($pageLabels[$key] ?? $key) ?></h5>
            <form method="POST" action="<?= adminUrl('page=pages&action=save') ?>">
                <?= csrfField() ?>
                <input type="hidden" name="page_key" value="<?= e($key) ?>">

                <h6 class="text-muted mb-3">Page Hero</h6>
                <div class="mb-3"><label class="form-label">Breadcrumb Label</label><input type="text" name="breadcrumb_label" class="form-control" value="<?= e($editPage['breadcrumb_label'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Hero Title</label><input type="text" name="hero_title" class="form-control" value="<?= e($editPage['hero_title'] ?? '') ?>">
                    <?php if ($key === 'about'): ?><small class="text-muted">Leave blank to use “About {Site Name}” from Settings.</small><?php endif; ?>
                </div>
                <div class="mb-3"><label class="form-label">Hero Subtitle / Lead</label><textarea name="hero_subtitle" class="form-control" rows="2"><?= e($editPage['hero_subtitle'] ?? '') ?></textarea>
                    <?php if ($key === 'about'): ?><small class="text-muted">Leave blank to use the site tagline from Settings.</small><?php endif; ?>
                    <?php if ($key === 'contact'): ?><small class="text-muted">Leave blank to use Response Time from Settings.</small><?php endif; ?>
                </div>

                <?php if ($key !== 'blog' && $key !== 'contact' && $key !== 'service_detail'): ?>
                <hr>
                <h6 class="text-muted mb-3">Bottom CTA</h6>
                <div class="mb-3"><label class="form-label">CTA Title</label><input type="text" name="cta_title" class="form-control" value="<?= e($editPage['cta_title'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">CTA Subtitle</label><input type="text" name="cta_subtitle" class="form-control" value="<?= e($editPage['cta_subtitle'] ?? '') ?>"></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">CTA Button Text</label><input type="text" name="cta_button_text" class="form-control" value="<?= e($editPage['cta_button_text'] ?? '') ?>"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">CTA Button URL</label><input type="text" name="cta_button_url" class="form-control" value="<?= e($editPage['cta_button_url'] ?? '') ?>"></div>
                </div>
                <?php elseif ($key === 'faq'): ?>
                <?php /* faq has CTA - already covered above */ ?>
                <?php elseif ($key === 'service_detail'): ?>
                <hr>
                <h6 class="text-muted mb-3">Sidebar Consultation Box</h6>
                <div class="mb-3"><label class="form-label">Sidebar Title</label><input type="text" name="cta_title" class="form-control" value="<?= e($editPage['cta_title'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Sidebar Text</label><textarea name="cta_subtitle" class="form-control" rows="2"><?= e($editPage['cta_subtitle'] ?? '') ?></textarea></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Button Text</label><input type="text" name="cta_button_text" class="form-control" value="<?= e($editPage['cta_button_text'] ?? '') ?>"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Button URL</label><input type="text" name="cta_button_url" class="form-control" value="<?= e($editPage['cta_button_url'] ?? '') ?>"></div>
                </div>
                <hr>
                <h6 class="text-muted mb-3">Section Headings</h6>
                <div class="row g-2">
                    <div class="col-md-6 mb-2"><label class="form-label">Overview</label><input type="text" name="overview_heading" class="form-control" value="<?= e($extra['overview_heading'] ?? 'Overview') ?>"></div>
                    <div class="col-md-6 mb-2"><label class="form-label">Challenge</label><input type="text" name="challenge_heading" class="form-control" value="<?= e($extra['challenge_heading'] ?? 'The Challenge') ?>"></div>
                    <div class="col-md-6 mb-2"><label class="form-label">Approach</label><input type="text" name="approach_heading" class="form-control" value="<?= e($extra['approach_heading'] ?? 'Our Approach') ?>"></div>
                    <div class="col-md-6 mb-2"><label class="form-label">Deliverables</label><input type="text" name="deliverables_heading" class="form-control" value="<?= e($extra['deliverables_heading'] ?? 'Deliverables') ?>"></div>
                    <div class="col-md-6 mb-2"><label class="form-label">Benefits</label><input type="text" name="benefits_heading" class="form-control" value="<?= e($extra['benefits_heading'] ?? 'Benefits for Your Facility') ?>"></div>
                    <div class="col-md-6 mb-2"><label class="form-label">Related Services</label><input type="text" name="related_heading" class="form-control" value="<?= e($extra['related_heading'] ?? 'Related Services') ?>"></div>
                </div>
                <?php elseif ($key === 'contact'): ?>
                <hr>
                <h6 class="text-muted mb-3">Contact Page Labels</h6>
                <div class="mb-3"><label class="form-label">Sidebar Title</label><input type="text" name="sidebar_title" class="form-control" value="<?= e($extra['sidebar_title'] ?? 'Get in Touch') ?>"></div>
                <div class="mb-3"><label class="form-label">Form Title</label><input type="text" name="form_title" class="form-control" value="<?= e($extra['form_title'] ?? 'Send Us a Message') ?>"></div>
                <div class="mb-3"><label class="form-label">FAQ Button Text</label><input type="text" name="faq_button_text" class="form-control" value="<?= e($extra['faq_button_text'] ?? '') ?>"></div>
                <?php elseif ($key === 'blog'): ?>
                <hr>
                <div class="mb-3"><label class="form-label">Empty State Message</label><textarea name="empty_message" class="form-control" rows="2"><?= e($extra['empty_message'] ?? '') ?></textarea></div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary">Save Page Content</button>
            </form>
        </div>
        <?php else: ?>
        <div class="admin-card"><p class="text-muted mb-0">Select a page to edit its hero and CTA text.</p></div>
        <?php endif; ?>
    </div>
</div>
