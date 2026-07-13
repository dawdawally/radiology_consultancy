<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Manage frequently asked questions shown on the public FAQ page.</p>
    <a href="<?= adminUrl('page=faq&action=create') ?>" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Add FAQ</a>
</div>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Question</th><th>Order</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= e(truncate($item['question'], 80)) ?></td>
                <td><?= (int) $item['sort_order'] ?></td>
                <td><?= $item['is_published'] ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-secondary">Draft</span>' ?></td>
                <td class="text-end">
                    <a href="<?= adminUrl('page=faq&action=edit&id=' . $item['id']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="<?= adminUrl('page=faq&action=delete&id=' . $item['id'] . '&csrf_token=' . csrfToken()) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this FAQ?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
