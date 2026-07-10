<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <h5 class="mb-3">Upload Image</h5>
            <form method="POST" action="<?= adminUrl('page=media&action=upload') ?>" enctype="multipart/form-data">
                <?= csrfField() ?>
                <div class="mb-3"><input type="file" name="file" class="form-control" accept="image/jpeg,image/png,image/webp" required></div>
                <p class="text-muted small">Allowed: JPG, PNG, WebP. Max 5MB.</p>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
<div class="admin-card">
    <h5 class="mb-3">Media Library</h5>
    <?php if (empty($items)): ?>
    <p class="text-muted">No files uploaded yet.</p>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($items as $item): ?>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="border rounded p-2 text-center">
                <img src="<?= uploadUrl($item['filename']) ?>" alt="<?= e($item['alt_text'] ?? '') ?>" class="img-fluid rounded mb-2" style="max-height:100px;object-fit:cover;">
                <small class="d-block text-truncate"><?= e($item['original_name']) ?></small>
                <a href="<?= adminUrl('page=media&action=delete&id=' . $item['id'] . '&csrf_token=' . csrfToken()) ?>" class="btn btn-sm btn-outline-danger mt-1" onclick="return confirm('Delete?')">Delete</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
