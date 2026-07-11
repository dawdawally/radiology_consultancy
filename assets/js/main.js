document.addEventListener('DOMContentLoaded', function () {
    initScrollReveal();

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
});

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
