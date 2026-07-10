<?php $isEdit = !empty($post); ?>
<div class="admin-card">
    <form method="POST" action="<?= url('admin/?page=blog&action=' . ($isEdit ? 'edit' : 'create')) ?>">
        <?= csrfField() ?>
        <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int) $post['id'] ?>"><?php endif; ?>
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="<?= e($post['title'] ?? '') ?>" required></div>
            <div class="col-md-4"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="<?= e($post['slug'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">— None —</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= (int) $cat['id'] ?>" <?= ($post['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Published At</label><input type="datetime-local" name="published_at" class="form-control" value="<?= $isEdit && $post['published_at'] ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : date('Y-m-d\TH:i') ?>"></div>
            <div class="col-md-4 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_published" class="form-check-input" id="pub" <?= ($post['is_published'] ?? 1) ? 'checked' : '' ?>><label class="form-check-label" for="pub">Published</label></div></div>
            <div class="col-12"><label class="form-label">Excerpt</label><textarea name="excerpt" class="form-control" rows="2"><?= e($post['excerpt'] ?? '') ?></textarea></div>
            <div class="col-12"><label class="form-label">Content (HTML)</label><textarea name="content" class="form-control" rows="12"><?= e($post['content'] ?? '') ?></textarea></div>
            <div class="col-md-6"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="<?= e($post['meta_title'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Meta Description</label><input type="text" name="meta_description" class="form-control" value="<?= e($post['meta_description'] ?? '') ?>"></div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Post</button>
            <a href="<?= url('admin/?page=blog') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
