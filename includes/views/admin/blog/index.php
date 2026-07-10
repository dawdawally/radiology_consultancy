<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Manage blog posts and resources.</p>
    <a href="<?= url('admin/?page=blog&action=create') ?>" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Add Post</a>
</div>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Published</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= e($post['title']) ?></td>
                <td><?= e($post['category_name'] ?? '—') ?></td>
                <td><?= $post['is_published'] ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-secondary">Draft</span>' ?></td>
                <td><?= formatDate($post['published_at'], 'd M Y') ?></td>
                <td class="text-end">
                    <a href="<?= url('admin/?page=blog&action=edit&id=' . $post['id']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="<?= url('admin/?page=blog&action=delete&id=' . $post['id'] . '&csrf_token=' . csrfToken()) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
