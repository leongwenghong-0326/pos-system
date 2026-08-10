"use strict";

function setTheme(theme) {
    const root = document.documentElement;
    if (theme === 'dark') {
        root.setAttribute('data-theme', 'dark');
        localStorage.setItem('posTheme', 'dark');
    } else {
        root.removeAttribute('data-theme');
        localStorage.setItem('posTheme', 'light');
    }
}

function toggleTheme() {
    const root = document.documentElement;
    const dark = root.getAttribute('data-theme') === 'dark';
    setTheme(dark ? 'light' : 'dark');
}

function initTheme() {
    const storedTheme = localStorage.getItem('posTheme');
    if (storedTheme === 'dark') {
        setTheme('dark');
    } else {
        setTheme('light');
    }
}

function initNav() {
    const url = window.location.pathname;
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (url.endsWith(href) || url.endsWith('/' + href)) {
            item.classList.add('active');
            item.setAttribute('aria-current', 'page');
        }
    });
}

window.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initNav();
});
