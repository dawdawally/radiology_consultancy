<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Manage all consultancy service pages.</p>
    <a href="<?= adminUrl('page=services&action=create') ?>" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Add Service</a>
</div>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Order</th><th>Title</th><th>Slug</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($services as $s): ?>
            <tr>
                <td><?= (int) $s['sort_order'] ?></td>
                <td><i class="fa-solid <?= e($s['icon']) ?> me-2 text-primary"></i><?= e($s['title']) ?></td>
                <td><code><?= e($s['slug']) ?></code></td>
                <td><?= $s['is_published'] ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-secondary">Draft</span>' ?></td>
                <td class="text-end">
                    <a href="<?= url('services/' . $s['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="<?= adminUrl('page=services&action=edit&id=' . $s['id']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="<?= adminUrl('page=services&action=delete&id=' . $s['id'] . '&csrf_token=' . csrfToken()) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this service?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
