document.addEventListener('DOMContentLoaded', function () {
    initScrollReveal();
    initAutoDismissAlerts();

    const navbar = document.querySelector('.site-navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        }, { passive: true });
    }

    document.querySelectorAll('form.needs-validation').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    initContactTopicField();
});

function initContactTopicField() {
    const topicSelect = document.getElementById('contactTopic');
    const otherWrap = document.getElementById('otherSubjectWrap');
    const subjectInput = document.getElementById('contactSubject');
    if (!topicSelect || !otherWrap || !subjectInput) {
        return;
    }

    const syncTopicField = function () {
        const isOther = topicSelect.value === 'other';
        otherWrap.style.display = isOther ? '' : 'none';
        subjectInput.required = isOther;
        if (!isOther) {
            subjectInput.value = '';
        }
    };

    topicSelect.addEventListener('change', syncTopicField);
    syncTopicField();
}

function initAutoDismissAlerts() {
    document.querySelectorAll('.alert-success.alert-dismissible').forEach(function (alert) {
        window.setTimeout(function () {
            bootstrap.Alert.getOrCreateInstance(alert).close();
        }, 5000);
    });
}

function initScrollReveal() {
    const elements = document.querySelectorAll('[data-aos]');
    if (!elements.length) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        elements.forEach(function (el) {
            el.classList.add('aos-visible');
        });
        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }

            const el = entry.target;
            const delay = parseInt(el.getAttribute('data-aos-delay') || '0', 10);
            window.setTimeout(function () {
                el.classList.add('aos-visible');
            }, delay);
            observer.unobserve(el);
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -60px 0px' });

    elements.forEach(function (el) {
        el.classList.add('aos-init');
        observer.observe(el);
    });
}
