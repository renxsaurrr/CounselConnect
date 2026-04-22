import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    // ─── Mobile Menu ──────────────────────────────────────────────
    const btn       = document.getElementById('mobile-menu-btn');
    const menu      = document.getElementById('mobile-menu');
    const hamburger = document.getElementById('hamburger-icon');
    const close     = document.getElementById('close-icon');

    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            hamburger.classList.toggle('hidden');
            close.classList.toggle('hidden');
        });
    }

    // ─── FAQ Accordion ────────────────────────────────────────────
    document.querySelectorAll('.faq-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const body  = btn.nextElementSibling;
            const arrow = btn.querySelector('.faq-arrow');
            const isOpen = !body.classList.contains('hidden');

            // Close all first
            document.querySelectorAll('.faq-body').forEach(b => b.classList.add('hidden'));
            document.querySelectorAll('.faq-arrow').forEach(a => a.classList.remove('rotate-180'));

            // Open clicked one if it was closed
            if (!isOpen) {
                body.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            }
        });
    });

    // ─── Escape key closes both modals ───────────────────────────
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.getElementById('login-modal')?.classList.add('hidden');
            document.getElementById('register-modal')?.classList.add('hidden');
        }
    });

});

// ─── Password Toggle — Login Modal ───────────────────────────
function togglePassword() {
    const input = document.getElementById('password');

    // Admin create/edit page uses pw-eye-show / pw-eye-hide
    const pwShow = document.getElementById('pw-eye-show');
    const pwHide = document.getElementById('pw-eye-hide');
    if (pwShow && pwHide) {
        const isVisible = pwShow.style.display === 'none';
        input.type = isVisible ? 'password' : 'text';
        pwShow.style.display = isVisible ? '' : 'none';
        pwHide.style.display = isVisible ? 'none' : '';
        return;
    }

    // Login modal uses eye-show / eye-hide
    const show = document.getElementById('eye-show');
    const hide  = document.getElementById('eye-hide');
    if (input.type === 'password') {
        input.type = 'text';
        show.classList.add('hidden');
        hide.classList.remove('hidden');
    } else {
        input.type = 'password';
        show.classList.remove('hidden');
        hide.classList.add('hidden');
    }
}

// ─── Password Toggle — Register Modal (password field) ───────
function toggleRegPassword() {
    const input   = document.getElementById('reg-password');
    const eyeShow = document.getElementById('reg-eye-show');
    const eyeHide = document.getElementById('reg-eye-hide');
    const isHidden = input.type === 'password';

    input.type = isHidden ? 'text' : 'password';
    eyeShow.classList.toggle('hidden', isHidden);
    eyeHide.classList.toggle('hidden', !isHidden);
}

// ─── Password Toggle — Register Modal (confirm password) ─────
function toggleConfirmPassword() {
    const input   = document.getElementById('password_confirmation');
    const eyeShow = document.getElementById('confirm-eye-show');
    const eyeHide = document.getElementById('confirm-eye-hide');
    const isHidden = input.type === 'password';

    input.type = isHidden ? 'text' : 'password';
    eyeShow.classList.toggle('hidden', isHidden);
    eyeHide.classList.toggle('hidden', !isHidden);
}

// Expose to global scope for inline onclick attributes in Blade
window.togglePassword        = togglePassword;
window.toggleRegPassword     = toggleRegPassword;
window.toggleConfirmPassword = toggleConfirmPassword;