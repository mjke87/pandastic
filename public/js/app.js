// Color scheme toggle logic
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('toggle-color-scheme');
    if (!btn) return;
    const setScheme = scheme => {
        document.documentElement.setAttribute('data-theme', scheme);
        localStorage.setItem('color-scheme', scheme);
        btn.textContent = scheme === 'light' ? '🌙' : '☀️';
    };
    // On load, apply saved scheme
    const saved = localStorage.getItem('color-scheme');
    if (saved) {
        setScheme(saved);
    } else {
        // Set initial icon based on default (light)
        btn.textContent = '☀️';
    }
    btn.addEventListener('click', () => {
        const current = document.documentElement.getAttribute('data-theme') || 'light';
        setScheme(current === 'dark' ? 'light' : 'dark');
    });
});
