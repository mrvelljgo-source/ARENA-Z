/**
 * ARENA Z — User Dashboard JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {

    // =========================================================
    // 1. Sidebar toggle (mobile)
    // =========================================================
    const sidebar = document.getElementById('udSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    const closeBtn = document.getElementById('sidebarCloseBtn');

    function openSidebar() {
        sidebar?.classList.add('open');
        overlay?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar?.classList.remove('open');
        overlay?.classList.remove('active');
        document.body.style.overflow = '';
    }

    toggleBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { closeSidebar(); }
    });

    // =========================================================
    // 2. Auto-dismiss flash alerts
    // =========================================================
    const alerts = document.querySelectorAll('[data-flash]');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(function () { alert.remove(); }, 500);
        }, 5000);
    });

    // =========================================================
    // 3. Pemain cadangan toggle
    // =========================================================
    const subToggle = document.getElementById('subToggle');
    const subFields = document.getElementById('subFields');

    if (subToggle && subFields) {
        subToggle.addEventListener('change', function () {
            if (this.checked) {
                subFields.classList.add('show');
                subFields.querySelectorAll('input, select').forEach(function (el) {
                    if (el.dataset.required) {
                        el.required = true;
                    }
                });
            } else {
                subFields.classList.remove('show');
                subFields.querySelectorAll('input, select').forEach(function (el) {
                    el.required = false;
                    el.value = '';
                });
            }
        });

        // Jika halaman di-reload dengan old input dan checkbox aktif
        if (subToggle.checked) {
            subFields.classList.add('show');
        }
    }

    // =========================================================
    // 4. Validasi form pendaftaran tim — dihapus, validasi
    //    kapten sudah ditangani oleh backend via captain_index
    // =========================================================

    // =========================================================
    // 5. Password field toggle visibility
    // =========================================================
    document.querySelectorAll('[data-password-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const target = document.querySelector(this.dataset.passwordToggle);
            if (!target) { return; }
            const isPassword = target.type === 'password';
            target.type = isPassword ? 'text' : 'password';
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
            }
        });
    });

    // =========================================================
    // 6. Confirm dangerous actions
    // =========================================================
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            const msg = this.dataset.confirm || 'Yakin ingin melanjutkan?';
            if (!confirm(msg)) {
                e.preventDefault();
            }
        });
    });

});
