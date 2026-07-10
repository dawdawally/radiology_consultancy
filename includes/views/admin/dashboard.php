<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fa-solid fa-envelope"></i></div>
            <div><div class="text-muted small">Unread Messages</div><strong class="fs-4"><?= (int) $unreadMessages ?></strong></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fa-solid fa-briefcase-medical"></i></div>
            <div><div class="text-muted small">Services</div><strong class="fs-4"><?= (int) $totalServices ?></strong></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fa-solid fa-newspaper"></i></div>
            <div><div class="text-muted small">Blog Posts</div><strong class="fs-4"><?= (int) $totalPosts ?></strong></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fa-solid fa-globe"></i></div>
            <div><div class="text-muted small">Website</div><strong class="fs-6"><a href="<?= url() ?>" target="_blank">View Live Site</a></strong></div>
        </div>
    </div>
</div>

<div class="admin-card">
    <h5 class="mb-3">Recent Contact Messages</h5>
    <?php if (empty($recentMessages)): ?>
    <p class="text-muted mb-0">No messages yet.</p>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Date</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($recentMessages as $msg): ?>
            <tr>
                <td><?= e($msg['name']) ?><?= !$msg['is_read'] ? ' <span class="badge badge-unread">New</span>' : '' ?></td>
                <td><?= e($msg['email']) ?></td>
                <td><?= e(truncate($msg['subject'] ?? $msg['message'], 40)) ?></td>
                <td><?= formatDate($msg['created_at'], 'd M Y H:i') ?></td>
                <td><a href="<?= url('admin/?page=messages&view=' . $msg['id']) ?>" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
