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

    document.querySelectorAll('[data-confirm]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            const message = link.getAttribute('data-confirm') || 'Are you sure?';
            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    initMessagesInbox();
});

function initMessagesInbox() {
    const inbox = document.getElementById('messagesInbox');
    const list = document.getElementById('messagesList');
    const searchInput = document.getElementById('messagesSearch');
    const sortSelect = document.getElementById('messagesSort');
    const countBadge = document.getElementById('messagesCount');
    const noResults = document.getElementById('messagesNoResults');

    if (!inbox || !list || !searchInput || !sortSelect) {
        return;
    }

    const rows = Array.from(list.querySelectorAll('.message-inbox-row'));

    const applyFilters = function () {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        rows.forEach(function (row) {
            const haystack = row.getAttribute('data-search') || '';
            const matches = query === '' || haystack.includes(query);
            row.classList.toggle('d-none', !matches);
            if (matches) {
                visibleCount += 1;
            }
        });

        if (countBadge) {
            countBadge.textContent = String(visibleCount);
        }
        if (noResults) {
            noResults.classList.toggle('d-none', visibleCount > 0);
        }
    };

    const applySort = function () {
        const mode = sortSelect.value;
        const visibleRows = rows.filter(function (row) {
            return !row.classList.contains('d-none');
        });
        const hiddenRows = rows.filter(function (row) {
            return row.classList.contains('d-none');
        });

        visibleRows.sort(function (a, b) {
            if (mode === 'date-desc' || mode === 'date-asc') {
                const dateA = parseInt(a.getAttribute('data-date') || '0', 10);
                const dateB = parseInt(b.getAttribute('data-date') || '0', 10);
                return mode === 'date-desc' ? dateB - dateA : dateA - dateB;
            }

            const subjectA = a.getAttribute('data-subject') || '';
            const subjectB = b.getAttribute('data-subject') || '';
            const cmp = subjectA.localeCompare(subjectB);
            return mode === 'subject-desc' ? -cmp : cmp;
        });

        visibleRows.concat(hiddenRows).forEach(function (row) {
            list.appendChild(row);
        });
    };

    searchInput.addEventListener('input', function () {
        applyFilters();
        applySort();
    });

    sortSelect.addEventListener('change', applySort);

    applyFilters();
    applySort();
}
