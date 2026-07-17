<?php
$sectionKey = $editSection['section_key'] ?? '';
$extra = parseJsonField($editSection['extra_data'] ?? null);
$stats = $extra['stats'] ?? [['value' => '', 'label' => ''], ['value' => '', 'label' => ''], ['value' => '', 'label' => '']];
$features = $extra['features'] ?? [];
$items = $extra['items'] ?? [];
while (count($stats) < 3) {
    $stats[] = ['value' => '', 'label' => ''];
}
?>
<div class="row g-4">
    <div class="col-lg-3">
        <div class="admin-card p-0">
            <div class="list-group list-group-flush">
                <?php foreach ($sections as $section): ?>
                <a href="<?= adminUrl('page=homepage&edit=' . e($section['section_key'])) ?>"
                   class="list-group-item list-group-item-action <?= $sectionKey === $section['section_key'] ? 'active' : '' ?>">
                    <?= e(ucwords(str_replace('_', ' ', $section['section_key']))) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <?php if ($editSection): ?>
        <div class="admin-card">
            <h5 class="mb-3">Edit: <?= e(ucwords(str_replace('_', ' ', $sectionKey))) ?></h5>
            <form method="POST" action="<?= adminUrl('page=homepage&action=save') ?>">
                <?= csrfField() ?>
                <input type="hidden" name="section_key" value="<?= e($sectionKey) ?>">

                <?php if ($sectionKey === 'hero'): ?>
                <div class="mb-3">
                    <label class="form-label">Hero Badge (brand name shown above title)</label>
                    <input type="text" name="badge" class="form-control" value="<?= e($extra['badge'] ?? '') ?>" placeholder="Radiation Equipment Consultancy">
                </div>
                <?php endif; ?>

                <?php if (!in_array($sectionKey, ['hero', 'cta'], true)): ?>
                <div class="mb-3">
                    <label class="form-label">Section Label (small eyebrow text)</label>
                    <input type="text" name="section_label" class="form-control" value="<?= e($extra['section_label'] ?? '') ?>">
                </div>
                <?php endif; ?>

                <div class="mb-3"><label class="form-label">Title</label><input type="text" name="title" class="form-control" value="<?= e($editSection['title'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Subtitle</label><input type="text" name="subtitle" class="form-control" value="<?= e($editSection['subtitle'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Content (HTML allowed)</label><textarea name="content" class="form-control" rows="5"><?= e($editSection['content'] ?? '') ?></textarea></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Primary Button Text</label><input type="text" name="button_text" class="form-control" value="<?= e($editSection['button_text'] ?? '') ?>"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Primary Button URL</label><input type="text" name="button_url" class="form-control" value="<?= e($editSection['button_url'] ?? '') ?>"></div>
                </div>

                <?php if ($sectionKey === 'hero'): ?>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Secondary Button Text</label><input type="text" name="button2_text" class="form-control" value="<?= e($extra['button2_text'] ?? '') ?>"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Secondary Button URL</label><input type="text" name="button2_url" class="form-control" value="<?= e($extra['button2_url'] ?? '') ?>"></div>
                </div>
                <hr>
                <h6 class="mb-3">Hero Stats Card</h6>
                <p class="small text-muted mb-3">The “Specialist Service Areas” value is calculated automatically from published services and cannot be edited here.</p>
                <?php
                $liveServicesCount = (new ServiceModel())->countPublished();
                for ($i = 0; $i < 3; $i++):
                    $isServicesStat = (($stats[$i]['source'] ?? '') === 'services_count')
                        || stripos($stats[$i]['label'] ?? '', 'Specialist Service') !== false;
                ?>
                <div class="row mb-2 align-items-center">
                    <div class="col-md-4">
                        <?php if ($isServicesStat): ?>
                        <input type="text" class="form-control" value="<?= (int) $liveServicesCount ?>" readonly>
                        <input type="hidden" name="stat_value[]" value="auto">
                        <input type="hidden" name="stat_source[]" value="services_count">
                        <?php else: ?>
                        <input type="text" name="stat_value[]" class="form-control" placeholder="Value (e.g. 30+)" value="<?= e($stats[$i]['value'] ?? '') ?>">
                        <input type="hidden" name="stat_source[]" value="">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="stat_label[]" class="form-control" placeholder="Label (e.g. Years Combined Experience)" value="<?= e($stats[$i]['label'] ?? ($isServicesStat ? 'Specialist Service Areas' : '')) ?>" <?= $isServicesStat ? '' : '' ?>>
                        <?php if ($isServicesStat): ?><small class="text-muted">Auto-updated from Services</small><?php endif; ?>
                    </div>
                </div>
                <?php endfor; ?>
                <?php endif; ?>

                <?php if ($sectionKey === 'about_preview'): ?>
                <hr>
                <h6 class="mb-3">Feature Boxes (right column)</h6>
                <?php
                while (count($features) < 4) {
                    $features[] = ['icon' => '', 'title' => '', 'description' => ''];
                }
                foreach ($features as $i => $feature):
                ?>
                <div class="border rounded p-3 mb-3">
                    <div class="row g-2">
                        <div class="col-md-4"><input type="text" name="feature_icon[]" class="form-control" placeholder="Icon (fa-shield-halved)" value="<?= e($feature['icon'] ?? '') ?>"></div>
                        <div class="col-md-8"><input type="text" name="feature_title[]" class="form-control" placeholder="Title" value="<?= e($feature['title'] ?? '') ?>"></div>
                        <div class="col-12"><textarea name="feature_description[]" class="form-control" rows="2" placeholder="Description"><?= e($feature['description'] ?? '') ?></textarea></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>

                <?php if (in_array($sectionKey, ['why_choose_us', 'process'], true)): ?>
                <hr>
                <h6 class="mb-3"><?= $sectionKey === 'process' ? 'Process Steps' : 'Why Choose Us Items' ?></h6>
                <div class="mb-3"><label class="form-label">Items (JSON)</label><textarea name="extra_data_items" class="form-control font-monospace" rows="10"><?= e(json_encode(['items' => $items], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?></textarea>
                <small class="text-muted">Format: {"items":[{"icon":"fa-shield-halved","title":"...","description":"..."}]}</small></div>
                <?php endif; ?>

                <div class="form-check mb-3"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" <?= !empty($editSection['is_active']) ? 'checked' : '' ?>><label class="form-check-label" for="is_active">Active (show on homepage)</label></div>
                <button type="submit" class="btn btn-primary">Save Section</button>
            </form>
        </div>
        <?php else: ?>
        <div class="admin-card"><p class="text-muted mb-0">Select a homepage section to edit.</p></div>
        <?php endif; ?>
    </div>
</div>
