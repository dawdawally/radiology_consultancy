document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.admin-content .alert-success.alert-dismissible').forEach(function (alert) {
        setTimeout(function () {
            bootstrap.Alert.getOrCreateInstance(alert).close();
        }, 5000);
    });

    const sidebarNav = document.querySelector('.sidebar-nav');
    const activeLink = sidebarNav?.querySelector('.sidebar-link.active');
    if (sidebarNav && activeLink) {
        activeLink.scrollIntoView({ block: 'nearest', inline: 'nearest' });
    }
});
