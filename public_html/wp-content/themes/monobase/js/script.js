"use strict";

document.addEventListener('DOMContentLoaded', function () {

    toggleMobileMenu();
    toggleSideBar();
    copyURL();

    initDropdown();
    openSubMenu();
    darkMode();


    function toggleMobileMenu() {
        const toggle = document.getElementById('menu-toggle');

        if (!toggle) {
            return;
        }

        toggle.addEventListener('click', function () {
            const isOpen = document.body.classList.toggle('menu-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    function toggleSideBar() {

        const toggleBtns = document.querySelectorAll('.toggle-posts');

        if (toggleBtns.length < 1) {
            return;
        }

        toggleBtns.forEach(toggle => {
            toggle.addEventListener('click', function () {
                const isToggle = document.body.classList.toggle('toggle-posts');
                toggleBtns.forEach(btn => {
                    btn.setAttribute('aria-expanded', isToggle ? 'true' : 'false');
                });
            })
        })
    }

    function copyURL() {
        const copyURL = document.getElementById('copy-url');

        if (copyURL) {
            copyURL.addEventListener("click", function () {
                const url = window.location.href;  // Get current URL

                // Use the newer clipboard API when available
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url)
                        .then(() => {
                            const tooltip = copyURL.getAttribute('data-tooltip');
                            const tooltipInvert = copyURL.getAttribute('data-toggle-tooltip');
                            const link = copyURL.querySelector('.mb-icon-link');
                            const check = copyURL.querySelector('.mb-icon-check');
                            link.setAttribute('hidden', '');
                            check.removeAttribute('hidden');
                            copyURL.setAttribute('data-tooltip', tooltipInvert);
                            setTimeout(() => {
                                check.setAttribute('hidden', '');
                                link.removeAttribute('hidden');
                                copyURL.setAttribute('data-tooltip', tooltip);
                            }, 2000);
                        })
                        .catch((error) => console.error('Could not copy text: ', error));
                }
            });
        }
    }

    function openSubMenu() {
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-toggle');
            if (!btn) {
                return;
            }
            const list = document.getElementById(btn.getAttribute('aria-controls'));
            if (!list) {
                return;
            }
            const listItems = list.closest('li.menu-item-has-children');
            const expanded = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            if (expanded) {
                list.setAttribute('hidden', '');
                listItems.classList.remove('is-open');
            } else {
                list.removeAttribute('hidden');
                listItems.classList.add('is-open');
            }
        });

// Optional: close on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            document.querySelectorAll('.btn-toggle[aria-expanded="true"]').forEach(btn => {
                const list = document.getElementById(btn.getAttribute('aria-controls'));
                btn.setAttribute('aria-expanded', 'false');
                if (list) list.setAttribute('hidden', '');
            });
        });

        const subMenu = document.querySelectorAll('.sub-menu');
        if (subMenu.length < 1) {
            return
        }

        subMenu.forEach(menu => {
            if (!menu.hasAttribute('hidden')) {
                return;
            }
            const liActive = menu.querySelector('li.current-menu-item');

            if (!liActive) {
                return;
            }

            const parent = menu.closest('li.menu-item-has-children');
            parent.classList.add('is-open');
            const btn = parent.querySelector('.btn-toggle');
            btn.setAttribute('aria-expanded', 'true');
            menu.removeAttribute('hidden');
        });

    }

    function initDropdown() {
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('.dropdown-button');
            const list = dropdown.querySelector('.dropdown-list');

            if (!button || !list) return;

            // toggle open
            button.addEventListener('click', function (e) {
                e.stopPropagation();

                // закрити інші відкриті
                dropdowns.forEach(d => {
                    if (d !== dropdown) d.classList.remove('is-open');
                });

                // toggle поточного
                dropdown.classList.toggle('is-open');
            });
        });

        // close on click outside
        document.addEventListener('click', function (e) {
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('is-open');
                }
            });
        });

        // close on ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                dropdowns.forEach(dropdown => dropdown.classList.remove('is-open'));
            }
        });
    }

    function darkMode() {
        const darkMode = document.getElementById('theme-mode');
        const body = document.body;
        if (!darkMode) return;

        const darkText = darkMode.getAttribute('data-tooltip');          // "Enable dark mode"
        const lightText = darkMode.getAttribute('data-toggle-tooltip');  // "Enable light mode"

        // --- Helpers for cookies ---
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const d = new Date();
                d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + d.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        // --- Restore theme early ---
        const savedTheme = getCookie('theme-mode');
        if (savedTheme === 'dark') {
            body.classList.add('theme-dark');
        }

        updateTooltip();

        // --- Toggle ---
        darkMode.addEventListener('click', function () {
            body.classList.toggle('theme-dark');
            if (body.classList.contains('theme-dark')) {
                setCookie('theme-mode', 'dark', 30); // зберігаємо на 30 днів
            } else {
                setCookie('theme-mode', 'light', 30);
            }
            updateTooltip();
        });

        function updateTooltip() {
            if (body.classList.contains('theme-dark')) {
                darkMode.setAttribute('data-tooltip', lightText);
                darkMode.setAttribute('aria-label', lightText);
            } else {
                darkMode.setAttribute('data-tooltip', darkText);
                darkMode.setAttribute('aria-label', darkText);
            }
        }
    }

});