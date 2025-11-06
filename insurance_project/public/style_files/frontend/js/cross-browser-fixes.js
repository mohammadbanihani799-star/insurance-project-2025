/**
 * Cross-Browser JavaScript Polyfills & Fixes
 * Ensures compatibility with IE11, Safari, older Chrome/Firefox
 * Enhanced mobile support for iOS and Android
 */

(function() {
    'use strict';

    // =================================================================
    // 1. Object.assign Polyfill (IE11)
    // =================================================================
    if (typeof Object.assign !== 'function') {
        Object.defineProperty(Object, 'assign', {
            value: function assign(target) {
                if (target == null) {
                    throw new TypeError('Cannot convert undefined or null to object');
                }
                var to = Object(target);
                for (var index = 1; index < arguments.length; index++) {
                    var nextSource = arguments[index];
                    if (nextSource != null) {
                        for (var nextKey in nextSource) {
                            if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                                to[nextKey] = nextSource[nextKey];
                            }
                        }
                    }
                }
                return to;
            },
            writable: true,
            configurable: true
        });
    }

    // =================================================================
    // 2. Array.from Polyfill (IE11)
    // =================================================================
    if (!Array.from) {
        Array.from = function(object) {
            return [].slice.call(object);
        };
    }

    // =================================================================
    // 3. Element.closest Polyfill (IE11)
    // =================================================================
    if (!Element.prototype.matches) {
        Element.prototype.matches = Element.prototype.msMatchesSelector ||
                                    Element.prototype.webkitMatchesSelector;
    }

    if (!Element.prototype.closest) {
        Element.prototype.closest = function(s) {
            var el = this;
            do {
                if (Element.prototype.matches.call(el, s)) return el;
                el = el.parentElement || el.parentNode;
            } while (el !== null && el.nodeType === 1);
            return null;
        };
    }

    // =================================================================
    // 4. CustomEvent Polyfill (IE11)
    // =================================================================
    if (typeof window.CustomEvent !== 'function') {
        function CustomEvent(event, params) {
            params = params || { bubbles: false, cancelable: false, detail: null };
            var evt = document.createEvent('CustomEvent');
            evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
            return evt;
        }
        window.CustomEvent = CustomEvent;
    }

    // =================================================================
    // 5. Viewport Height Fix (Mobile browsers)
    // =================================================================
    function setVH() {
        var vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', vh + 'px');
    }

    setVH();
    window.addEventListener('resize', setVH);
    window.addEventListener('orientationchange', setVH);

    // =================================================================
    // 6. iOS Scroll Fix
    // =================================================================
    if (/iPhone|iPad|iPod/.test(navigator.userAgent)) {
        document.body.addEventListener('touchmove', function(e) {
            var target = e.target;
            var scrollable = target.closest('.scrollable, .overflow-x-auto, .bc-table-container');

            if (!scrollable) {
                e.preventDefault();
            }
        }, { passive: false });
    }

    // =================================================================
    // 7. Passive Event Listeners
    // =================================================================
    var supportsPassive = false;
    try {
        var opts = Object.defineProperty({}, 'passive', {
            get: function() {
                supportsPassive = true;
            }
        });
        window.addEventListener('testPassive', null, opts);
        window.removeEventListener('testPassive', null, opts);
    } catch (e) {}

    window.passiveSupported = supportsPassive;

    // =================================================================
    // 8. Intersection Observer Polyfill (Lazy Loading)
    // =================================================================
    if (!('IntersectionObserver' in window)) {
        // Simple fallback: load all images immediately
        document.addEventListener('DOMContentLoaded', function() {
            var lazyImages = document.querySelectorAll('img[loading="lazy"]');
            Array.from(lazyImages).forEach(function(img) {
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                }
                img.classList.add('loaded');
            });
        });
    } else {
        // Modern browsers: use Intersection Observer
        document.addEventListener('DOMContentLoaded', function() {
            var lazyImages = document.querySelectorAll('img[loading="lazy"]');

            var imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                        }
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(function(img) {
                imageObserver.observe(img);
            });
        });
    }

    // =================================================================
    // 9. Smooth Scroll Polyfill
    // =================================================================
    if (!('scrollBehavior' in document.documentElement.style)) {
        var smoothScroll = function(target) {
            var targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
            var startPosition = window.pageYOffset;
            var distance = targetPosition - startPosition;
            var duration = 500;
            var start = null;

            window.requestAnimationFrame(step);

            function step(timestamp) {
                if (!start) start = timestamp;
                var progress = timestamp - start;
                var percent = Math.min(progress / duration, 1);

                window.scrollTo(0, startPosition + distance * percent);

                if (progress < duration) {
                    window.requestAnimationFrame(step);
                }
            }
        };

        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    smoothScroll(target);
                }
            });
        });
    }

    // =================================================================
    // 10. Object-Fit Polyfill (IE11)
    // =================================================================
    if (!('objectFit' in document.documentElement.style)) {
        document.addEventListener('DOMContentLoaded', function() {
            var images = document.querySelectorAll('img[style*="object-fit"]');

            Array.from(images).forEach(function(img) {
                var parent = img.parentElement;
                var src = img.src;

                parent.style.backgroundImage = 'url(' + src + ')';
                parent.style.backgroundSize = 'cover';
                parent.style.backgroundPosition = 'center';
                img.style.opacity = '0';
            });
        });
    }

    // =================================================================
    // 11. Focus Visible Polyfill
    // =================================================================
    var hadKeyboardEvent = true;
    var hadFocusVisibleRecently = false;
    var hadFocusVisibleRecentlyTimeout = null;

    var inputTypesWhitelist = {
        text: true,
        search: true,
        url: true,
        tel: true,
        email: true,
        password: true,
        number: true,
        date: true,
        month: true,
        week: true,
        time: true,
        datetime: true,
        'datetime-local': true
    };

    function isValidFocusTarget(el) {
        if (el && el !== document && el.nodeName !== 'HTML' && el.nodeName !== 'BODY') {
            return true;
        }
        return false;
    }

    function focusTriggersKeyboardModality(el) {
        var type = el.type;
        var tagName = el.tagName;

        if (tagName === 'INPUT' && inputTypesWhitelist[type] && !el.readOnly) {
            return true;
        }

        if (tagName === 'TEXTAREA' && !el.readOnly) {
            return true;
        }

        if (el.isContentEditable) {
            return true;
        }

        return false;
    }

    function addFocusVisibleClass(el) {
        if (el.classList.contains('focus-visible')) {
            return;
        }
        el.classList.add('focus-visible');
        el.setAttribute('data-focus-visible-added', '');
    }

    function removeFocusVisibleClass(el) {
        if (!el.hasAttribute('data-focus-visible-added')) {
            return;
        }
        el.classList.remove('focus-visible');
        el.removeAttribute('data-focus-visible-added');
    }

    document.addEventListener('keydown', function() {
        hadKeyboardEvent = true;
    }, true);

    document.addEventListener('mousedown', function() {
        hadKeyboardEvent = false;
    }, true);

    document.addEventListener('pointerdown', function() {
        hadKeyboardEvent = false;
    }, true);

    document.addEventListener('touchstart', function() {
        hadKeyboardEvent = false;
    }, true);

    document.addEventListener('focus', function(e) {
        if (!isValidFocusTarget(e.target)) {
            return;
        }

        if (hadKeyboardEvent || focusTriggersKeyboardModality(e.target)) {
            addFocusVisibleClass(e.target);
        }
    }, true);

    document.addEventListener('blur', function(e) {
        if (!isValidFocusTarget(e.target)) {
            return;
        }

        if (e.target.classList.contains('focus-visible') ||
            e.target.hasAttribute('data-focus-visible-added')) {
            hadFocusVisibleRecently = true;
            window.clearTimeout(hadFocusVisibleRecentlyTimeout);
            hadFocusVisibleRecentlyTimeout = window.setTimeout(function() {
                hadFocusVisibleRecently = false;
            }, 100);
            removeFocusVisibleClass(e.target);
        }
    }, true);

    // =================================================================
    // 12. Browser Detection & Body Classes
    // =================================================================
    var ua = navigator.userAgent;
    var body = document.body;

    // Add browser-specific classes
    if (ua.indexOf('MSIE') !== -1 || ua.indexOf('Trident/') !== -1) {
        body.classList.add('browser-ie');
    } else if (ua.indexOf('Edge') !== -1) {
        body.classList.add('browser-edge');
    } else if (ua.indexOf('Chrome') !== -1) {
        body.classList.add('browser-chrome');
    } else if (ua.indexOf('Safari') !== -1) {
        body.classList.add('browser-safari');
    } else if (ua.indexOf('Firefox') !== -1) {
        body.classList.add('browser-firefox');
    }

    // Add OS-specific classes
    if (ua.indexOf('Win') !== -1) {
        body.classList.add('os-windows');
    } else if (ua.indexOf('Mac') !== -1) {
        body.classList.add('os-mac');
    } else if (ua.indexOf('Linux') !== -1) {
        body.classList.add('os-linux');
    } else if (ua.indexOf('Android') !== -1) {
        body.classList.add('os-android');
    } else if (/iPhone|iPad|iPod/.test(ua)) {
        body.classList.add('os-ios');
    }

    // Add device-specific classes
    if (/Mobi|Android/i.test(ua)) {
        body.classList.add('device-mobile');
    } else if (/Tablet|iPad/i.test(ua)) {
        body.classList.add('device-tablet');
    } else {
        body.classList.add('device-desktop');
    }

    // =================================================================
    // 13. Print Event Handlers
    // =================================================================
    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                document.body.classList.add('is-printing');
            } else {
                document.body.classList.remove('is-printing');
            }
        });
    }

    window.addEventListener('beforeprint', function() {
        document.body.classList.add('is-printing');
    });

    window.addEventListener('afterprint', function() {
        document.body.classList.remove('is-printing');
    });

    // =================================================================
    // 14. Connection Speed Detection
    // =================================================================
    if (navigator.connection || navigator.mozConnection || navigator.webkitConnection) {
        var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

        function updateConnectionStatus() {
            if (connection.effectiveType) {
                body.setAttribute('data-connection', connection.effectiveType);

                // Slow connection hint
                if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g') {
                    body.classList.add('slow-connection');
                } else {
                    body.classList.remove('slow-connection');
                }
            }
        }

        updateConnectionStatus();
        connection.addEventListener('change', updateConnectionStatus);
    }

    // =================================================================
    // 15. Save Data Mode
    // =================================================================
    if (navigator.connection && navigator.connection.saveData === true) {
        body.classList.add('save-data-mode');
    }

    // =================================================================
    // 16. Console Log (Production Safety)
    // =================================================================
    if (typeof console === 'undefined') {
        window.console = {
            log: function() {},
            warn: function() {},
            error: function() {}
        };
    }

    // =================================================================
    // 17. Ready State Check
    // =================================================================
    function domReady(fn) {
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(fn, 1);
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    // Export utilities
    window.BCareCrossBrowser = {
        domReady: domReady,
        passiveSupported: supportsPassive,
        setVH: setVH
    };

    // =================================================================
    // 18. Performance Monitoring
    // =================================================================
    if (window.performance && window.performance.mark) {
        window.performance.mark('bcareScriptLoaded');
    }

    console.log('BCare Cross-Browser Support Loaded ✓');

})();
