<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Manage client testimonials and case studies.</p>
    <a href="<?= adminUrl('page=testimonials&action=create') ?>" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Add Testimonial</a>
</div>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Client</th><th>Organization</th><th>Outcome</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= e($item['client_name']) ?></td>
                <td><?= e($item['organization']) ?></td>
                <td><?= e(truncate($item['outcome_metric'] ?? '', 40)) ?></td>
                <td><?= $item['is_published'] ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-secondary">Draft</span>' ?></td>
                <td class="text-end">
                    <a href="<?= adminUrl('page=testimonials&action=edit&id=' . $item['id']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="<?= adminUrl('page=testimonials&action=delete&id=' . $item['id'] . '&csrf_token=' . csrfToken()) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
