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

    document.querySelectorAll('form[data-loading-on-submit]').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (!form.checkValidity()) {
                return;
            }

            const button = form.querySelector('button[type="submit"]');
            if (!button || button.disabled) {
                return;
            }

            const loadingText = button.getAttribute('data-loading-text') || 'Please wait...';
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>'
                + loadingText;
        });
    });
});
