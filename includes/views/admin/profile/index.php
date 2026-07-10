<div class="row g-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <h5 class="mb-3">Account Information</h5>
            <dl class="mb-0">
                <dt>Username</dt><dd><?= e($user['username'] ?? '') ?></dd>
                <dt>Email</dt><dd><?= e($user['email'] ?? '') ?></dd>
                <dt>Full Name</dt><dd><?= e($user['full_name'] ?? '') ?></dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card">
            <h5 class="mb-3">Change Password</h5>
            <form method="POST" action="<?= url('admin/?page=profile&action=password') ?>">
                <?= csrfField() ?>
                <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" required minlength="8"></div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>
</div>
