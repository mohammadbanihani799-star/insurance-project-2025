/**
 * Performance-Optimized JavaScript
 * Version: 3.0.0
 * Features: Passive Event Listeners, Modern Carousel, Optimized Performance
 */

'use strict';

// ========================================
// 1. PERFORMANCE CONFIGURATION
// ========================================

const PerformanceConfig = {
    // Passive Events Support Detection
    passiveSupported: false,

    // Throttle & Debounce Timings
    scrollThrottle: 100,
    resizeDebounce: 250,
    inputDebounce: 300,

    // Lazy Loading
    lazyLoadOffset: 50,

    // Animation Frame
    useRAF: true,

    // Observer Options
    intersectionThreshold: 0.1,

    // Touch Settings
    touchThreshold: 10
};

// ========================================
// 2. PASSIVE EVENTS DETECTION
// ========================================

(function detectPassiveSupport() {
    try {
        const options = {
            get passive() {
                PerformanceConfig.passiveSupported = true;
                return false;
            }
        };

        window.addEventListener('test', null, options);
        window.removeEventListener('test', null, options);
    } catch (err) {
        PerformanceConfig.passiveSupported = false;
    }
})();

// Helper function for passive options
function getPassiveOptions(passive = true) {
    return PerformanceConfig.passiveSupported ? { passive } : false;
}

// ========================================
// 3. OPTIMIZED EVENT LISTENERS
// ========================================

class OptimizedEventManager {
    constructor() {
        this.listeners = new Map();
        this.rafId = null;
        this.init();
    }

    init() {
        this.setupScrollListener();
        this.setupResizeListener();
        this.setupTouchListeners();
        this.setupMouseListeners();
        this.setupKeyboardListeners();
        this.setupFormListeners();
    }

    // Optimized Scroll Handling with RAF and Throttle
    setupScrollListener() {
        let ticking = false;
        let lastScrollY = 0;

        const updateScroll = () => {
            const scrollY = window.pageYOffset;

            // Scroll direction detection
            const direction = scrollY > lastScrollY ? 'down' : 'up';

            // Emit custom event
            window.dispatchEvent(new CustomEvent('optimizedScroll', {
                detail: {
                    scrollY,
                    direction,
                    delta: scrollY - lastScrollY
                }
            }));

            lastScrollY = scrollY;
            ticking = false;
        };

        const requestTick = () => {
            if (!ticking) {
                if (PerformanceConfig.useRAF) {
                    requestAnimationFrame(updateScroll);
                } else {
                    setTimeout(updateScroll, PerformanceConfig.scrollThrottle);
                }
                ticking = true;
            }
        };

        // Add passive scroll listener
        window.addEventListener('scroll', requestTick, getPassiveOptions(true));

        // Also listen to wheel events passively
        window.addEventListener('wheel', (e) => {
            // Only prevent default when necessary
            if (!shouldAllowScroll(e.target)) {
                e.preventDefault();
            }
        }, getPassiveOptions(false));
    }

    // Optimized Resize Handling
    setupResizeListener() {
        let resizeTimer;

        const handleResize = () => {
            clearTimeout(resizeTimer);

            resizeTimer = setTimeout(() => {
                // Emit optimized resize event
                window.dispatchEvent(new CustomEvent('optimizedResize', {
                    detail: {
                        width: window.innerWidth,
                        height: window.innerHeight,
                        orientation: window.innerWidth > window.innerHeight ? 'landscape' : 'portrait'
                    }
                }));
            }, PerformanceConfig.resizeDebounce);
        };

        window.addEventListener('resize', handleResize, getPassiveOptions(true));
        window.addEventListener('orientationchange', handleResize, getPassiveOptions(true));
    }

    // Optimized Touch Handlers
    setupTouchListeners() {
        let touchStartX = 0;
        let touchStartY = 0;
        let touchEndX = 0;
        let touchEndY = 0;

        const handleTouchStart = (e) => {
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
        };

        const handleTouchEnd = (e) => {
            touchEndX = e.changedTouches[0].screenX;
            touchEndY = e.changedTouches[0].screenY;
            handleSwipe();
        };

        const handleSwipe = () => {
            const deltaX = touchEndX - touchStartX;
            const deltaY = touchEndY - touchStartY;

            // Only trigger if movement exceeds threshold
            if (Math.abs(deltaX) < PerformanceConfig.touchThreshold &&
                Math.abs(deltaY) < PerformanceConfig.touchThreshold) {
                return;
            }

            // Determine swipe direction
            let direction = '';
            if (Math.abs(deltaX) > Math.abs(deltaY)) {
                direction = deltaX > 0 ? 'right' : 'left';
            } else {
                direction = deltaY > 0 ? 'down' : 'up';
            }

            // Emit swipe event
            window.dispatchEvent(new CustomEvent('swipe', {
                detail: {
                    direction,
                    deltaX,
                    deltaY,
                    startX: touchStartX,
                    startY: touchStartY,
                    endX: touchEndX,
                    endY: touchEndY
                }
            }));
        };

        // Add passive touch listeners
        document.addEventListener('touchstart', handleTouchStart, getPassiveOptions(true));
        document.addEventListener('touchend', handleTouchEnd, getPassiveOptions(true));
        document.addEventListener('touchmove', (e) => {
            // Handle scroll locking if needed
            if (shouldPreventScroll(e.target)) {
                e.preventDefault();
            }
        }, getPassiveOptions(false));

        // Prevent pinch zoom
        document.addEventListener('gesturestart', (e) => {
            e.preventDefault();
        }, getPassiveOptions(false));
    }

    // Optimized Mouse Handlers
    setupMouseListeners() {
        // Passive mousemove with throttling
        let mouseTimer;
        document.addEventListener('mousemove', (e) => {
            clearTimeout(mouseTimer);
            mouseTimer = setTimeout(() => {
                window.dispatchEvent(new CustomEvent('optimizedMousemove', {
                    detail: { x: e.clientX, y: e.clientY }
                }));
            }, 50);
        }, getPassiveOptions(true));

        // Passive mousewheel
        document.addEventListener('mousewheel', (e) => {
            // Custom handling
        }, getPassiveOptions(true));

        // DOMMouseScroll for Firefox
        document.addEventListener('DOMMouseScroll', (e) => {
            // Custom handling
        }, getPassiveOptions(true));
    }

    // Optimized Keyboard Handlers
    setupKeyboardListeners() {
        // Prevent rapid key events
        const keyState = new Map();

        document.addEventListener('keydown', (e) => {
            if (keyState.get(e.key)) return;
            keyState.set(e.key, true);

            // Handle keyboard navigation
            if (e.key === 'Tab') {
                // Allow default tab behavior
            } else if (e.key === 'Escape') {
                // Handle escape key
                window.dispatchEvent(new CustomEvent('escapePressed'));
            }
        }, getPassiveOptions(false));

        document.addEventListener('keyup', (e) => {
            keyState.delete(e.key);
        }, getPassiveOptions(true));
    }

    // Optimized Form Input Handlers
    setupFormListeners() {
        // Debounced input handling
        const inputTimers = new WeakMap();

        document.addEventListener('input', (e) => {
            if (!(e.target instanceof HTMLInputElement ||
                  e.target instanceof HTMLTextAreaElement)) {
                return;
            }

            // Clear existing timer for this input
            if (inputTimers.has(e.target)) {
                clearTimeout(inputTimers.get(e.target));
            }

            // Set new debounced timer
            const timer = setTimeout(() => {
                e.target.dispatchEvent(new CustomEvent('debouncedInput', {
                    detail: { value: e.target.value }
                }));
            }, PerformanceConfig.inputDebounce);

            inputTimers.set(e.target, timer);
        }, getPassiveOptions(true));

        // Passive focus/blur events
        document.addEventListener('focus', (e) => {
            // Handle focus
        }, getPassiveOptions(true));

        document.addEventListener('blur', (e) => {
            // Handle blur
        }, getPassiveOptions(true));
    }
}

// Helper functions
function shouldAllowScroll(target) {
    // Check if target is scrollable element
    const scrollableElements = ['INPUT', 'TEXTAREA', 'SELECT'];
    return !scrollableElements.includes(target.tagName);
}

function shouldPreventScroll(target) {
    // Check if scroll should be prevented
    return target.closest('.no-scroll, .modal-open, .drawer-open');
}

// ========================================
// 4. MODERN CAROUSEL (Slick Alternative)
// ========================================

class ModernCarousel {
    constructor(element, options = {}) {
        this.element = element;
        this.options = {
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 3000,
            dots: true,
            arrows: true,
            infinite: true,
            speed: 500,
            fade: false,
            cssEase: 'cubic-bezier(0.4, 0, 0.2, 1)',
            pauseOnHover: true,
            pauseOnFocus: true,
            swipe: true,
            swipeToSlide: true,
            touchThreshold: 5,
            useCSS: true,
            useTransform: true,
            variableWidth: false,
            vertical: false,
            verticalSwiping: false,
            rtl: false,
            waitForAnimate: true,
            responsive: [],
            lazyLoad: 'progressive',
            ...options
        };

        this.currentSlide = 0;
        this.slideCount = 0;
        this.isAnimating = false;
        this.autoplayTimer = null;
        this.touchStartX = null;
        this.touchStartY = null;

        this.init();
    }

    init() {
        this.setupDOM();
        this.calculateDimensions();
        this.setupEventListeners();
        this.setupIntersectionObserver();

        if (this.options.autoplay) {
            this.startAutoplay();
        }

        // Apply initial position
        this.goToSlide(0, false);
    }

    setupDOM() {
        // Wrap slides
        this.track = this.element.querySelector('.carousel-track');
        if (!this.track) {
            const slides = Array.from(this.element.children);
            this.track = document.createElement('div');
            this.track.className = 'carousel-track';
            slides.forEach(slide => this.track.appendChild(slide));
            this.element.appendChild(this.track);
        }

        this.slides = Array.from(this.track.children);
        this.slideCount = this.slides.length;

        // Add classes
        this.element.classList.add('modern-carousel');
        this.slides.forEach((slide, index) => {
            slide.classList.add('carousel-slide');
            slide.dataset.slideIndex = index;
        });

        // Create navigation
        if (this.options.arrows) {
            this.createArrows();
        }

        if (this.options.dots) {
            this.createDots();
        }
    }

    calculateDimensions() {
        const containerWidth = this.element.offsetWidth;
        const slidesToShow = this.getResponsiveSetting('slidesToShow');

        this.slideWidth = containerWidth / slidesToShow;

        this.slides.forEach(slide => {
            if (!this.options.variableWidth) {
                slide.style.width = `${this.slideWidth}px`;
            }
        });

        // Set track width
        if (!this.options.vertical) {
            this.track.style.width = `${this.slideWidth * this.slideCount}px`;
        }
    }

    setupEventListeners() {
        // Window resize with debounce
        window.addEventListener('optimizedResize', () => {
            this.calculateDimensions();
            this.goToSlide(this.currentSlide, false);
        });

        // Touch events with passive listeners
        if (this.options.swipe) {
            this.track.addEventListener('touchstart', (e) => {
                this.handleTouchStart(e);
            }, getPassiveOptions(true));

            this.track.addEventListener('touchmove', (e) => {
                this.handleTouchMove(e);
            }, getPassiveOptions(false));

            this.track.addEventListener('touchend', (e) => {
                this.handleTouchEnd(e);
            }, getPassiveOptions(true));
        }

        // Mouse events for drag
        this.track.addEventListener('mousedown', (e) => {
            this.handleMouseDown(e);
        }, getPassiveOptions(true));

        // Pause on hover
        if (this.options.pauseOnHover && this.options.autoplay) {
            this.element.addEventListener('mouseenter', () => {
                this.stopAutoplay();
            }, getPassiveOptions(true));

            this.element.addEventListener('mouseleave', () => {
                this.startAutoplay();
            }, getPassiveOptions(true));
        }

        // Keyboard navigation
        this.element.addEventListener('keydown', (e) => {
            this.handleKeyboard(e);
        }, getPassiveOptions(false));
    }

    setupIntersectionObserver() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (this.options.autoplay) {
                            this.startAutoplay();
                        }
                        // Lazy load images
                        if (this.options.lazyLoad) {
                            this.lazyLoadImages(entry.target);
                        }
                    } else {
                        this.stopAutoplay();
                    }
                });
            }, {
                threshold: PerformanceConfig.intersectionThreshold
            });

            observer.observe(this.element);
        }
    }

    createArrows() {
        // Previous arrow
        this.prevArrow = document.createElement('button');
        this.prevArrow.className = 'carousel-arrow carousel-prev';
        this.prevArrow.innerHTML = '<svg><use href="#icon-chevron-left"></use></svg>';
        this.prevArrow.setAttribute('aria-label', 'Previous slide');
        this.prevArrow.addEventListener('click', () => this.prev(), getPassiveOptions(false));

        // Next arrow
        this.nextArrow = document.createElement('button');
        this.nextArrow.className = 'carousel-arrow carousel-next';
        this.nextArrow.innerHTML = '<svg><use href="#icon-chevron-right"></use></svg>';
        this.nextArrow.setAttribute('aria-label', 'Next slide');
        this.nextArrow.addEventListener('click', () => this.next(), getPassiveOptions(false));

        this.element.appendChild(this.prevArrow);
        this.element.appendChild(this.nextArrow);
    }

    createDots() {
        this.dotsContainer = document.createElement('div');
        this.dotsContainer.className = 'carousel-dots';

        const dotsCount = Math.ceil(this.slideCount / this.options.slidesToScroll);

        for (let i = 0; i < dotsCount; i++) {
            const dot = document.createElement('button');
            dot.className = 'carousel-dot';
            dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
            dot.dataset.slideIndex = i * this.options.slidesToScroll;

            dot.addEventListener('click', () => {
                this.goToSlide(i * this.options.slidesToScroll);
            }, getPassiveOptions(false));

            this.dotsContainer.appendChild(dot);
        }

        this.element.appendChild(this.dotsContainer);
        this.updateDots();
    }

    updateDots() {
        if (!this.options.dots) return;

        const dots = this.dotsContainer.querySelectorAll('.carousel-dot');
        const activeDotIndex = Math.floor(this.currentSlide / this.options.slidesToScroll);

        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === activeDotIndex);
        });
    }

    goToSlide(index, animate = true) {
        if (this.isAnimating && this.options.waitForAnimate) return;

        // Handle infinite scroll
        if (this.options.infinite) {
            if (index < 0) {
                index = this.slideCount - 1;
            } else if (index >= this.slideCount) {
                index = 0;
            }
        } else {
            // Clamp to valid range
            index = Math.max(0, Math.min(index, this.slideCount - this.options.slidesToShow));
        }

        this.currentSlide = index;

        // Calculate transform
        const translateValue = this.options.vertical
            ? `translateY(-${index * 100 / this.options.slidesToShow}%)`
            : `translateX(-${index * 100 / this.options.slidesToShow}%)`;

        // Apply transform
        if (animate && this.options.speed > 0) {
            this.isAnimating = true;
            this.track.style.transition = `transform ${this.options.speed}ms ${this.options.cssEase}`;

            setTimeout(() => {
                this.isAnimating = false;
            }, this.options.speed);
        } else {
            this.track.style.transition = 'none';
        }

        this.track.style.transform = translateValue;

        // Update UI
        this.updateDots();
        this.updateArrows();

        // Emit event
        this.element.dispatchEvent(new CustomEvent('slideChange', {
            detail: { currentSlide: this.currentSlide }
        }));
    }

    next() {
        this.goToSlide(this.currentSlide + this.options.slidesToScroll);
    }

    prev() {
        this.goToSlide(this.currentSlide - this.options.slidesToScroll);
    }

    startAutoplay() {
        if (!this.options.autoplay || this.autoplayTimer) return;

        this.autoplayTimer = setInterval(() => {
            this.next();
        }, this.options.autoplaySpeed);
    }

    stopAutoplay() {
        if (this.autoplayTimer) {
            clearInterval(this.autoplayTimer);
            this.autoplayTimer = null;
        }
    }

    handleTouchStart(e) {
        this.touchStartX = e.touches[0].clientX;
        this.touchStartY = e.touches[0].clientY;
        this.stopAutoplay();
    }

    handleTouchMove(e) {
        if (!this.touchStartX || !this.touchStartY) return;

        const touchEndX = e.touches[0].clientX;
        const touchEndY = e.touches[0].clientY;

        const deltaX = this.touchStartX - touchEndX;
        const deltaY = this.touchStartY - touchEndY;

        // Determine if horizontal swipe
        if (Math.abs(deltaX) > Math.abs(deltaY)) {
            e.preventDefault();

            // Visual feedback during swipe
            const swipeProgress = deltaX / this.slideWidth;
            const currentTransform = -this.currentSlide * 100 / this.options.slidesToShow;
            const newTransform = currentTransform - (swipeProgress * 10);

            this.track.style.transition = 'none';
            this.track.style.transform = `translateX(${newTransform}%)`;
        }
    }

    handleTouchEnd(e) {
        if (!this.touchStartX || !this.touchStartY) return;

        const touchEndX = e.changedTouches[0].clientX;
        const deltaX = this.touchStartX - touchEndX;

        // Check if swipe threshold met
        if (Math.abs(deltaX) > this.options.touchThreshold) {
            if (deltaX > 0) {
                this.next();
            } else {
                this.prev();
            }
        } else {
            // Snap back to current slide
            this.goToSlide(this.currentSlide);
        }

        this.touchStartX = null;
        this.touchStartY = null;

        if (this.options.autoplay) {
            this.startAutoplay();
        }
    }

    handleMouseDown(e) {
        // Implement mouse drag similar to touch
    }

    handleKeyboard(e) {
        switch(e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                this.prev();
                break;
            case 'ArrowRight':
                e.preventDefault();
                this.next();
                break;
            case 'Home':
                e.preventDefault();
                this.goToSlide(0);
                break;
            case 'End':
                e.preventDefault();
                this.goToSlide(this.slideCount - 1);
                break;
        }
    }

    updateArrows() {
        if (!this.options.arrows) return;

        if (!this.options.infinite) {
            this.prevArrow.disabled = this.currentSlide === 0;
            this.nextArrow.disabled = this.currentSlide >= this.slideCount - this.options.slidesToShow;
        }
    }

    lazyLoadImages(slide) {
        const images = slide.querySelectorAll('img[data-src]');
        images.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                img.classList.add('loaded');
            }
        });
    }

    getResponsiveSetting(setting) {
        // Check responsive breakpoints
        const width = window.innerWidth;
        let value = this.options[setting];

        this.options.responsive.forEach(breakpoint => {
            if (width <= breakpoint.breakpoint) {
                if (breakpoint.settings[setting] !== undefined) {
                    value = breakpoint.settings[setting];
                }
            }
        });

        return value;
    }

    destroy() {
        this.stopAutoplay();
        // Remove event listeners and clean up DOM
    }
}

// ========================================
// 5. GLIDE.JS INTEGRATION (Better Alternative)
// ========================================

class GlideWrapper {
    constructor(selector, options = {}) {
        this.selector = selector;
        this.defaultOptions = {
            type: 'carousel',
            startAt: 0,
            perView: 3,
            focusAt: 'center',
            gap: 20,
            autoplay: 3000,
            hoverpause: true,
            keyboard: true,
            bound: false,
            swipeThreshold: 80,
            dragThreshold: 120,
            animationDuration: 400,
            rewind: true,
            animationTimingFunc: 'cubic-bezier(0.165, 0.840, 0.440, 1.000)',
            breakpoints: {
                1200: { perView: 3 },
                768: { perView: 2 },
                576: { perView: 1 }
            }
        };

        this.options = { ...this.defaultOptions, ...options };
        this.init();
    }

    async init() {
        // Dynamically load Glide.js if not present
        if (typeof Glide === 'undefined') {
            await this.loadGlide();
        }

        this.glide = new Glide(this.selector, this.options);

        // Setup passive event listeners
        this.setupEventListeners();

        // Mount with extensions
        this.glide.mount();
    }

    async loadGlide() {
        // Load Glide CSS
        const css = document.createElement('link');
        css.rel = 'stylesheet';
        css.href = 'https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.core.min.css';
        document.head.appendChild(css);

        // Load Glide JS
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/glide.min.js';
            script.onload = resolve;
            script.onerror = reject;
            document.body.appendChild(script);
        });
    }

    setupEventListeners() {
        const element = document.querySelector(this.selector);

        // Add passive touch listeners
        element.addEventListener('touchstart', () => {
            this.glide.disable();
        }, getPassiveOptions(true));

        element.addEventListener('touchend', () => {
            this.glide.enable();
        }, getPassiveOptions(true));

        // Pause on hover with passive listeners
        element.addEventListener('mouseenter', () => {
            if (this.options.hoverpause) {
                this.glide.pause();
            }
        }, getPassiveOptions(true));

        element.addEventListener('mouseleave', () => {
            if (this.options.hoverpause && this.options.autoplay) {
                this.glide.play();
            }
        }, getPassiveOptions(true));
    }
}

// ========================================
// 6. SWIPER.JS INTEGRATION (Most Modern)
// ========================================

class SwiperWrapper {
    constructor(selector, options = {}) {
        this.selector = selector;
        this.defaultOptions = {
            // Core
            direction: 'horizontal',
            loop: true,
            speed: 400,
            spaceBetween: 30,
            slidesPerView: 'auto',
            centeredSlides: false,

            // Autoplay
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },

            // Navigation
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // Pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true
            },

            // Effects
            effect: 'slide', // 'fade', 'cube', 'coverflow', 'flip'

            // Touch
            touchEventsTarget: 'wrapper',
            touchRatio: 1,
            touchAngle: 45,
            simulateTouch: true,
            shortSwipes: true,
            longSwipes: true,
            longSwipesRatio: 0.5,
            longSwipesMs: 300,

            // Responsive
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            },

            // Accessibility
            a11y: {
                enabled: true,
                prevSlideMessage: 'Previous slide',
                nextSlideMessage: 'Next slide',
                firstSlideMessage: 'This is the first slide',
                lastSlideMessage: 'This is the last slide',
                paginationBulletMessage: 'Go to slide {{index}}'
            },

            // Lazy Loading
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 2,
                loadOnTransitionStart: true,
                elementClass: 'swiper-lazy',
                loadingClass: 'swiper-lazy-loading',
                loadedClass: 'swiper-lazy-loaded',
                preloaderClass: 'swiper-lazy-preloader'
            },

            // Observer
            observer: true,
            observeParents: true,
            observeSlideChildren: true,

            // Passive Listeners
            passiveListeners: true,

            // Prevent clicks
            preventClicks: true,
            preventClicksPropagation: true,

            // Resistance
            resistance: true,
            resistanceRatio: 0.85
        };

        this.options = { ...this.defaultOptions, ...options };
        this.init();
    }

    async init() {
        // Load Swiper if not present
        if (typeof Swiper === 'undefined') {
            await this.loadSwiper();
        }

        // Initialize Swiper with passive event listeners enabled
        this.swiper = new Swiper(this.selector, this.options);

        // Add custom passive event listeners
        this.setupCustomListeners();
    }

    async loadSwiper() {
        // Load Swiper CSS
        const css = document.createElement('link');
        css.rel = 'stylesheet';
        css.href = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css';
        document.head.appendChild(css);

        // Load Swiper JS
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js';
            script.onload = resolve;
            script.onerror = reject;
            document.body.appendChild(script);
        });
    }

    setupCustomListeners() {
        const element = document.querySelector(this.selector);

        // Performance monitoring
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.name.includes('swiper')) {
                        console.debug('Swiper Performance:', entry.duration);
                    }
                }
            });

            observer.observe({ entryTypes: ['measure'] });
        }

        // Visibility change handling
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.swiper.autoplay.stop();
            } else {
                this.swiper.autoplay.start();
            }
        }, getPassiveOptions(true));
    }
}

// ========================================
// 7. INITIALIZATION
// ========================================

document.addEventListener('DOMContentLoaded', () => {
    // Initialize optimized event manager
    const eventManager = new OptimizedEventManager();

    // Initialize carousels
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        // Use ModernCarousel (custom implementation)
        new ModernCarousel(carousel, {
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: { slidesToShow: 2 }
                },
                {
                    breakpoint: 640,
                    settings: { slidesToShow: 1 }
                }
            ]
        });
    });

    // Initialize Swiper for hero sliders
    const heroSliders = document.querySelectorAll('.hero-slider');
    heroSliders.forEach(slider => {
        new SwiperWrapper(slider, {
            effect: 'fade',
            autoplay: {
                delay: 5000
            },
            pagination: {
                type: 'progressbar'
            }
        });
    });

    // Initialize Glide for product carousels
    const productCarousels = document.querySelectorAll('.product-carousel');
    productCarousels.forEach(carousel => {
        new GlideWrapper(carousel, {
            type: 'carousel',
            perView: 4,
            autoplay: 3000
        });
    });

    // Listen to optimized events
    window.addEventListener('optimizedScroll', (e) => {
        // Handle optimized scroll
        if (e.detail.scrollY > 100) {
            document.body.classList.add('scrolled');
        } else {
            document.body.classList.remove('scrolled');
        }
    });

    window.addEventListener('optimizedResize', (e) => {
        // Handle optimized resize
        console.log('Window resized:', e.detail);
    });

    window.addEventListener('swipe', (e) => {
        // Handle swipe gestures
        console.log('Swipe detected:', e.detail.direction);
    });
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        OptimizedEventManager,
        ModernCarousel,
        GlideWrapper,
        SwiperWrapper,
        getPassiveOptions
    };
}
