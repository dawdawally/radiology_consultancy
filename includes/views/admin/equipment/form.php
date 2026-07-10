<?php $isEdit = !empty($item); ?>
<div class="admin-card">
    <form method="POST" action="<?= adminUrl('page=equipment&action=' . ($isEdit ? 'edit' : 'create')) ?>">
        <?= csrfField() ?>
        <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Category *</label><input type="text" name="category" class="form-control" value="<?= e($item['category'] ?? '') ?>" required placeholder="Radiotherapy"></div>
            <div class="col-md-6"><label class="form-label">Equipment Name *</label><input type="text" name="name" class="form-control" value="<?= e($item['name'] ?? '') ?>" required></div>
            <div class="col-md-4"><label class="form-label">Icon</label><input type="text" name="icon" class="form-control" value="<?= e($item['icon'] ?? 'fa-microscope') ?>"></div>
            <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= e((string)($item['sort_order'] ?? 0)) ?>"></div>
            <div class="col-md-4 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_published" class="form-check-input" id="pub" <?= ($item['is_published'] ?? 1) ? 'checked' : '' ?>><label class="form-check-label" for="pub">Published</label></div></div>
            <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4"><?= e($item['description'] ?? '') ?></textarea></div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= adminUrl('page=equipment') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
