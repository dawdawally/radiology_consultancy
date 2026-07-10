<header class="admin-topbar">
    <div>
        <h1 class="topbar-title"><?= e($pageHeading ?? 'Dashboard') ?></h1>
    </div>
    <div class="topbar-user">
        <span><i class="fa-solid fa-user-circle me-1"></i><?= e(currentUser()['full_name'] ?? 'Admin') ?></span>
    </div>
</header>
