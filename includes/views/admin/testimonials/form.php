<?php $isEdit = !empty($item); ?>
<div class="admin-card">
    <form method="POST" action="<?= url('admin/?page=testimonials&action=' . ($isEdit ? 'edit' : 'create')) ?>">
        <?= csrfField() ?>
        <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Client Name *</label><input type="text" name="client_name" class="form-control" value="<?= e($item['client_name'] ?? '') ?>" required></div>
            <div class="col-md-6"><label class="form-label">Organization *</label><input type="text" name="organization" class="form-control" value="<?= e($item['organization'] ?? '') ?>" required></div>
            <div class="col-md-6"><label class="form-label">Role</label><input type="text" name="role" class="form-control" value="<?= e($item['role'] ?? '') ?>"></div>
            <div class="col-md-3"><label class="form-label">Rating (1-5)</label><input type="number" name="rating" min="1" max="5" class="form-control" value="<?= e((string)($item['rating'] ?? 5)) ?>"></div>
            <div class="col-md-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= e((string)($item['sort_order'] ?? 0)) ?>"></div>
            <div class="col-12"><label class="form-label">Testimonial *</label><textarea name="content" class="form-control" rows="4" required><?= e($item['content'] ?? '') ?></textarea></div>
            <div class="col-12"><label class="form-label">Outcome Metric</label><input type="text" name="outcome_metric" class="form-control" value="<?= e($item['outcome_metric'] ?? '') ?>" placeholder="e.g. Commissioning completed 2 weeks ahead of schedule"></div>
            <div class="col-12"><div class="form-check"><input type="checkbox" name="is_published" class="form-check-input" id="pub" <?= ($item['is_published'] ?? 1) ? 'checked' : '' ?>><label class="form-check-label" for="pub">Published</label></div></div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= url('admin/?page=testimonials') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
