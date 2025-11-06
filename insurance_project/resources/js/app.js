// resources/js/app.js

import './bootstrap';

// ========== jQuery (MUST BE FIRST!) ==========
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// ========== Passive Events Fix (After jQuery) ==========
import './passive-listeners';

// ========== Alpine ==========
import Alpine from 'alpinejs';
window.Alpine = Alpine;

// ========== Bootstrap 5 ==========
import 'bootstrap/dist/css/bootstrap.min.css';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// ========== Slick ==========
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';
import 'slick-carousel';

// ========== AOS ==========
import 'aos/dist/aos.css';
import AOS from 'aos';

// ========== Fancybox v4 (بدون jQuery) ==========
import '@fancyapps/ui/dist/fancybox/fancybox.css';
import { Fancybox } from '@fancyapps/ui';

// ========== نسخ الأصول الثابتة عبر Vite (اختياري) ==========
// استيراد الخطوط والصور المطلوبة فقط
import.meta.glob([
  '../../style_files/frontend/img/**/*.{png,jpg,jpeg,gif,svg}',
  '../../style_files/frontend/fonts/**/*.{woff,woff2,ttf,eot}',
], { eager: true });

// ========== تهيئة بعد جاهزية DOM ==========
$(function () {
  // AOS
  AOS.init({ duration: 1000, once: true });

  // Fancybox v4
  Fancybox.bind('[data-fancybox]', {});

        // Slick Slider مع تحسينات الأداء
  if ($.fn.slick) {
    const $hero = $('.heroSlider');
    if ($hero.length && !$hero.hasClass('slick-initialized')) {
      $hero.slick({
      infinite: false,
      dots: true,
      rtl: true,
      autoplay: true,
      autoplaySpeed: 3000,
      speed: 500,
      cssEase: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
      useCSS: true,
      useTransform: true,
      waitForAnimate: false,
      lazyLoad: 'progressive',
      touchThreshold: 10,
      });
    }

    const $partners = $('.partnersSlider');
    if ($partners.length && !$partners.hasClass('slick-initialized')) {
      $partners.slick({
      dots: true,
      infinite: false,
      speed: 400,
      slidesToShow: 4,
      slidesToScroll: 1,
      rtl: true,
      cssEase: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
      useCSS: true,
      useTransform: true,
      waitForAnimate: false,
      lazyLoad: 'progressive',
      touchThreshold: 10,
      responsive: [
        { breakpoint: 1024, settings: { slidesToShow: 3, slidesToScroll: 3, infinite: true, dots: true } },
        { breakpoint: 600,  settings: { slidesToShow: 2, slidesToScroll: 2 } },
        { breakpoint: 480,  settings: { slidesToShow: 2, slidesToScroll: 1 } },
      ],
      });
    }

    console.log('✅ Slick Slider initialized with performance optimizations');
  } else {
    console.warn('⚠️ Slick غير محمّل.');
  }

  // Datepicker (لو موجود عبر npm أو سكربت منفصل)
  if ($.fn.datepicker) {
    $('.date-own').datepicker({ minViewMode: 2, format: 'yyyy' });
  }

  console.log('jQuery via Vite:', $.fn.jquery);
});

// شغّل Alpine في النهاية
Alpine.start();

// ========== SweetAlert2 ==========
// 1) Pre-load shim: queue early Swal.fire() calls until real library is ready
if (!window.SWal) {
	const __queue = [];
	window.__swalQueue = __queue;
	window.SWal = {
		fire: (...args) => __queue.push(args),
	};
}

// 2) Load SweetAlert2 via Vite and expose globally
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
window.SWal = Swal;

// 3) Drain any queued calls once real Swal is ready
if (Array.isArray(window.__swalQueue) && window.__swalQueue.length) {
	for (const args of window.__swalQueue) {
		try { Swal.fire(...args); } catch (_) {}
	}
	delete window.__swalQueue;
}

// 4) CDN fallback in case the page executes very early or module loading is delayed
(function ensureSwalAvailable() {
	if (typeof window.SWal?.fire === 'function') return;
	const s = document.createElement('script');
	s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
	s.defer = true;
	s.onload = () => {
		if (Array.isArray(window.__swalQueue) && typeof window.SWal?.fire === 'function') {
			for (const args of window.__swalQueue) {
				try { window.SWal.fire(...args); } catch (_) {}
			}
			delete window.__swalQueue;
		}
	};
	document.head.appendChild(s);
})();

console.log('SweetAlert2 via Vite:', Swal.fire);

// ========== DEBUG: trace unknown console messages ==========
(function () {
  const tag = '[TRACE]';
  const wrap = (fn, kind) => function (...args) {
    try {
      console.groupCollapsed(`${tag} ${kind}`);
      console[kind === 'error' ? 'error' : 'log'](...args);
      console.trace();
    } finally {
      console.groupEnd();
    }
    return fn.apply(this, args);
  };
  try {
    console.warn = wrap(console.warn, 'warn');
    console.error = wrap(console.error, 'error');
  } catch (_) {}

  window.addEventListener('error', e => {
    try {
      console.groupCollapsed(`${tag} window.error`);
      console.error(e.message, e.filename, e.lineno + ':' + e.colno);
      if (e.error) console.error(e.error);
      console.trace();
    } finally { console.groupEnd(); }
  }, { passive: true });

  window.addEventListener('unhandledrejection', e => {
    try {
      console.groupCollapsed(`${tag} unhandledrejection`);
      console.error(e.reason);
      console.trace();
    } finally { console.groupEnd(); }
  }, { passive: true });
})();
