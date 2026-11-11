/**
 * ARENA Z — Main JavaScript
 * Student Esports Tournament Platform
 */

document.addEventListener('DOMContentLoaded', function () {

    // =========================================================
    // 1. Mobile Navigation Toggle
    // =========================================================
    const mobileToggle = document.querySelector('.mobile-nav-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function () {
            navMenu.classList.toggle('show');
            const isExpanded = navMenu.classList.contains('show');
            mobileToggle.setAttribute('aria-expanded', isExpanded);
            mobileToggle.textContent = isExpanded ? '✕' : '☰';
        });

        // Close nav when clicking outside
        document.addEventListener('click', function (e) {
            if (!mobileToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('show');
                mobileToggle.textContent = '☰';
            }
        });

        // Close nav on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && navMenu.classList.contains('show')) {
                navMenu.classList.remove('show');
                mobileToggle.textContent = '☰';
            }
        });
    }

    // =========================================================
    // 2. Tournament Filter by Status (Client-side)
    // =========================================================
    const filterButtons = document.querySelectorAll('[data-filter]');
    const tournamentCards = document.querySelectorAll('.tournament-card[data-status]');

    if (filterButtons.length && tournamentCards.length) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => {
                    b.classList.remove('btn-primary', 'active');
                    b.classList.add('btn-secondary');
                });

                this.classList.remove('btn-secondary');
                this.classList.add('btn-primary', 'active');

                const filterValue = this.getAttribute('data-filter');

                tournamentCards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
                    if (filterValue === 'all' || cardStatus === filterValue) {
                        card.style.display = '';
                        card.style.animation = 'fadeIn 0.25s ease';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    // =========================================================
    // 3. Tournament Search Filter
    // =========================================================
    const searchInput = document.getElementById('tournamentSearch');
    if (searchInput && tournamentCards.length) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            tournamentCards.forEach(card => {
                const title = card.querySelector('.tournament-title')?.textContent.toLowerCase() || '';
                const game = card.querySelector('.tournament-game-tag')?.textContent.toLowerCase() || '';
                if (title.includes(query) || game.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // =========================================================
    // 4. Animated Stats Counter (Intersection Observer)
    // =========================================================
    const statNumbers = document.querySelectorAll('.stat-number');

    if (statNumbers.length && 'IntersectionObserver' in window) {
        const countObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    animateCount(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(el => countObserver.observe(el));
    }

    function animateCount(el) {
        const text = el.textContent.trim();
        // Extract the numeric portion
        const match = text.match(/(\d+)/);
        if (!match) return;

        const target = parseInt(match[1], 10);
        const suffix = text.replace(match[1], '');
        const duration = 1500;
        const start = performance.now();

        function update(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(eased * target);
            el.textContent = current + suffix;

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    // =========================================================
    // 5. Auto-dismiss Flash Messages
    // =========================================================
    const flashMessages = document.querySelectorAll('.flash-message, [data-flash]');
    flashMessages.forEach(msg => {
        setTimeout(() => {
            msg.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            msg.style.opacity = '0';
            msg.style.transform = 'translateY(-8px)';
            setTimeout(() => msg.remove(), 500);
        }, 4500);
    });

    // =========================================================
    // 6. Sticky header background on scroll
    // =========================================================
    const siteHeader = document.querySelector('.site-header');
    if (siteHeader) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 20) {
                siteHeader.style.boxShadow = '0 4px 24px rgba(0,0,0,0.5)';
            } else {
                siteHeader.style.boxShadow = 'none';
            }
        }, { passive: true });
    }

    // =========================================================
    // 7. Smooth card entrance on scroll (subtle)
    // =========================================================
    if ('IntersectionObserver' in window) {
        const cards = document.querySelectorAll('.step-card, .tournament-card');

        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    cardObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            cardObserver.observe(card);
        });
    }

});
