/**
 * 📱 Mobile Layout Fixer
 * Automatically fixes wide elements and organizes mobile layout
 */

(function() {
    'use strict';

    const MobileLayoutFixer = {
        init() {
            this.fixOnLoad();
            this.setupListeners();
            this.fixImages();
            this.fixTables();
            this.fixForms();
            this.centerContent();
        },

        fixOnLoad() {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.fixAllElements());
            } else {
                this.fixAllElements();
            }
        },

        setupListeners() {
            // Fix on window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => this.fixAllElements(), 250);
            });

            // Fix on orientation change
            window.addEventListener('orientationchange', () => {
                setTimeout(() => this.fixAllElements(), 300);
            });
        },

        fixAllElements() {
            const viewportWidth = window.innerWidth;
            
            // Only fix on mobile
            if (viewportWidth > 768) return;

            // Find all wide elements
            document.querySelectorAll('*').forEach(el => {
                if (el.offsetWidth > viewportWidth) {
                    this.fixElement(el);
                }
            });

            console.log('✅ Mobile layout fixed');
        },

        fixElement(el) {
            // Skip if already fixed
            if (el.classList.contains('mobile-fixed')) return;

            // Add mobile-fixed class
            el.classList.add('mobile-fixed');

            // Apply fixes
            el.style.maxWidth = '100%';
            el.style.width = '100%';
            el.style.overflowX = 'auto';
        },

        fixImages() {
            document.querySelectorAll('img').forEach(img => {
                if (!img.style.maxWidth) {
                    img.style.maxWidth = '100%';
                    img.style.height = 'auto';
                    img.style.display = 'block';
                }
            });
        },

        fixTables() {
            if (window.innerWidth <= 768) {
                document.querySelectorAll('table:not(.mobile-fixed)').forEach(table => {
                    // Wrap table in responsive div
                    if (!table.parentElement.classList.contains('table-responsive')) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'table-responsive';
                        table.parentNode.insertBefore(wrapper, table);
                        wrapper.appendChild(table);
                    }
                    table.classList.add('mobile-fixed');
                });
            }
        },

        fixForms() {
            if (window.innerWidth <= 768) {
                document.querySelectorAll('form:not(.mobile-fixed)').forEach(form => {
                    form.style.maxWidth = '100%';
                    form.style.margin = '0 auto';
                    form.classList.add('mobile-fixed');

                    // Fix form inputs
                    form.querySelectorAll('input, select, textarea').forEach(input => {
                        if (!input.style.fontSize) {
                            input.style.fontSize = '16px'; // Prevent zoom on iOS
                        }
                    });
                });
            }
        },

        centerContent() {
            if (window.innerWidth <= 768) {
                // Center main containers
                document.querySelectorAll('.container, .main-content, section').forEach(el => {
                    if (!el.classList.contains('mobile-centered')) {
                        el.style.marginLeft = 'auto';
                        el.style.marginRight = 'auto';
                        el.style.textAlign = 'center';
                        el.classList.add('mobile-centered');
                    }
                });

                // Center headings
                document.querySelectorAll('h1, h2, h3, h4, h5, h6').forEach(heading => {
                    if (!heading.classList.contains('mobile-centered')) {
                        heading.style.textAlign = 'center';
                        heading.classList.add('mobile-centered');
                    }
                });
            }
        }
    };

    // Initialize when ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => MobileLayoutFixer.init());
    } else {
        MobileLayoutFixer.init();
    }

    // Expose globally for debugging
    window.MobileLayoutFixer = MobileLayoutFixer;

    console.log('✅ Mobile Layout Fixer loaded');

})();
