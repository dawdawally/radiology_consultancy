<div class="row g-4">
    <div class="col-lg-3">
        <div class="admin-card p-0">
            <div class="list-group list-group-flush">
                <?php foreach ($sections as $section): ?>
                <a href="<?= url('admin/?page=homepage&edit=' . e($section['section_key'])) ?>"
                   class="list-group-item list-group-item-action <?= ($editSection['section_key'] ?? '') === $section['section_key'] ? 'active' : '' ?>">
                    <?= e(ucwords(str_replace('_', ' ', $section['section_key']))) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <?php if ($editSection): ?>
        <div class="admin-card">
            <h5 class="mb-3">Edit: <?= e(ucwords(str_replace('_', ' ', $editSection['section_key']))) ?></h5>
            <form method="POST" action="<?= url('admin/?page=homepage&action=save') ?>">
                <?= csrfField() ?>
                <input type="hidden" name="section_key" value="<?= e($editSection['section_key']) ?>">
                <div class="mb-3"><label class="form-label">Title</label><input type="text" name="title" class="form-control" value="<?= e($editSection['title']) ?>"></div>
                <div class="mb-3"><label class="form-label">Subtitle</label><input type="text" name="subtitle" class="form-control" value="<?= e($editSection['subtitle']) ?>"></div>
                <div class="mb-3"><label class="form-label">Content (HTML allowed)</label><textarea name="content" class="form-control" rows="5"><?= e($editSection['content']) ?></textarea></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Button Text</label><input type="text" name="button_text" class="form-control" value="<?= e($editSection['button_text']) ?>"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Button URL</label><input type="text" name="button_url" class="form-control" value="<?= e($editSection['button_url']) ?>"></div>
                </div>
                <?php if (in_array($editSection['section_key'], ['why_choose_us', 'process'], true)): ?>
                <div class="mb-3"><label class="form-label">Extra Data (JSON)</label><textarea name="extra_data" class="form-control font-monospace" rows="8"><?= e($editSection['extra_data']) ?></textarea><small class="text-muted">JSON with "items" array: {"items":[{"icon":"fa-shield","title":"...","description":"..."}]}</small></div>
                <?php endif; ?>
                <div class="form-check mb-3"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" <?= $editSection['is_active'] ? 'checked' : '' ?>><label class="form-check-label" for="is_active">Active</label></div>
                <button type="submit" class="btn btn-primary">Save Section</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>
