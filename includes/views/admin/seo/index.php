<div class="row g-4">
    <div class="col-lg-3">
        <div class="admin-card p-0">
            <div class="list-group list-group-flush">
                <?php foreach ($pages as $page): ?>
                <a href="<?= url('admin/?page=seo&edit=' . e($page['page_key'])) ?>" class="list-group-item list-group-item-action <?= $editKey === $page['page_key'] ? 'active' : '' ?>">
                    <?= e(ucwords(str_replace('_', ' ', $page['page_key']))) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="admin-card">
            <form method="POST" action="<?= url('admin/?page=seo&action=save') ?>">
                <?= csrfField() ?>
                <input type="hidden" name="page_key" value="<?= e($editKey) ?>">
                <div class="mb-3"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="<?= e($editPage['meta_title'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control" rows="3"><?= e($editPage['meta_description'] ?? '') ?></textarea></div>
                <div class="mb-3"><label class="form-label">Meta Keywords</label><input type="text" name="meta_keywords" class="form-control" value="<?= e($editPage['meta_keywords'] ?? '') ?>"></div>
                <button type="submit" class="btn btn-primary">Save SEO</button>
            </form>
        </div>
    </div>
</div>
