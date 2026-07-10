<?php
$isEdit = !empty($service);
$approach = $isEdit ? parseJsonField($service['approach'] ?? null) : [];
$deliverables = $isEdit ? parseJsonField($service['deliverables'] ?? null) : [];

$approachLines = '';
foreach ($approach as $i => $step) {
    $approachLines .= ($step['step'] ?? ($i + 1)) . '|' . ($step['title'] ?? '') . '|' . ($step['description'] ?? '') . "\n";
}
$deliverableLines = implode("\n", array_map(fn($d) => is_string($d) ? $d : ($d['title'] ?? ''), $deliverables));
?>
<div class="admin-card">
    <form method="POST" action="<?= adminUrl('page=services&action=' . ($isEdit ? 'edit' : 'create')) ?>">
        <?= csrfField() ?>
        <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int) $service['id'] ?>"><?php endif; ?>

        <div class="row g-3">
            <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="<?= e($service['title'] ?? '') ?>" required></div>
            <div class="col-md-4"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="<?= e($service['slug'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Icon (FontAwesome)</label><input type="text" name="icon" class="form-control" value="<?= e($service['icon'] ?? 'fa-cog') ?>" placeholder="fa-cog"></div>
            <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= e((string)($service['sort_order'] ?? 0)) ?>"></div>
            <div class="col-md-4 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_published" class="form-check-input" id="pub" <?= ($service['is_published'] ?? 1) ? 'checked' : '' ?>><label class="form-check-label" for="pub">Published</label></div></div>
            <div class="col-12"><label class="form-label">Short Description</label><textarea name="short_description" class="form-control" rows="2"><?= e($service['short_description'] ?? '') ?></textarea></div>
            <div class="col-12"><label class="form-label">Introduction (HTML)</label><textarea name="intro" class="form-control" rows="4"><?= e($service['intro'] ?? '') ?></textarea></div>
            <div class="col-12"><label class="form-label">The Challenge (HTML)</label><textarea name="challenge" class="form-control" rows="3"><?= e($service['challenge'] ?? '') ?></textarea></div>
            <div class="col-12"><label class="form-label">Approach Steps (one per line: step|title|description)</label><textarea name="approach_lines" class="form-control font-monospace" rows="6"><?= e(trim($approachLines)) ?></textarea></div>
            <div class="col-12"><label class="form-label">Deliverables (one per line)</label><textarea name="deliverables_lines" class="form-control" rows="4"><?= e($deliverableLines) ?></textarea></div>
            <div class="col-12"><label class="form-label">Benefits (HTML)</label><textarea name="benefits" class="form-control" rows="3"><?= e($service['benefits'] ?? '') ?></textarea></div>
            <div class="col-md-6"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="<?= e($service['meta_title'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Meta Description</label><input type="text" name="meta_description" class="form-control" value="<?= e($service['meta_description'] ?? '') ?>"></div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Service</button>
            <a href="<?= adminUrl('page=services') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
