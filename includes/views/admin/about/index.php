<div class="row g-4">
    <div class="col-lg-3">
        <div class="admin-card p-0">
            <div class="list-group list-group-flush">
                <?php foreach ($sections as $section): ?>
                <a href="<?= url('admin/?page=about&edit=' . e($section['section_key'])) ?>"
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
            <h5 class="mb-3">Edit: <?= e($editSection['title']) ?></h5>
            <form method="POST" action="<?= url('admin/?page=about&action=save') ?>">
                <?= csrfField() ?>
                <input type="hidden" name="section_key" value="<?= e($editSection['section_key']) ?>">
                <div class="mb-3"><label class="form-label">Title</label><input type="text" name="title" class="form-control" value="<?= e($editSection['title']) ?>"></div>
                <div class="mb-3"><label class="form-label">Content (HTML allowed)</label><textarea name="content" class="form-control" rows="12"><?= e($editSection['content']) ?></textarea></div>
                <button type="submit" class="btn btn-primary">Save Section</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>
