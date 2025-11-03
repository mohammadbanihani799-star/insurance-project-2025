// resources/js/app.js

import './bootstrap';

// ========== jQuery ==========
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// ========== Alpine ==========
import Alpine from 'alpinejs';
window.Alpine = Alpine;

// ========== Bootstrap 5 ==========
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';

// ========== Slick ==========
import 'slick-carousel';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

// ========== AOS ==========
import AOS from 'aos';
import 'aos/dist/aos.css';

// ========== Fancybox v4 (بدون jQuery) ==========
import { Fancybox } from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';

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

  // Slick
  if ($.fn.slick) {
    $('.heroSlider').slick({
      infinite: false,
      dots: true,
      rtl: true,
      autoplay: true,
      autoplaySpeed: 3000,
    });

    $('.partnersSlider').slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 1,
      rtl: true,
      responsive: [
        { breakpoint: 1024, settings: { slidesToShow: 3, slidesToScroll: 3, infinite: true, dots: true } },
        { breakpoint: 600,  settings: { slidesToShow: 2, slidesToScroll: 2 } },
        { breakpoint: 480,  settings: { slidesToShow: 2, slidesToScroll: 1 } },
      ],
    });
  } else {
    console.warn('Slick غير محمّل.');
  }

  // Datepicker (لو موجود عبر npm أو سكربت منفصل)
  if ($.fn.datepicker) {
    $('.date-own').datepicker({ minViewMode: 2, format: 'yyyy' });
  }

  console.log('jQuery via Vite:', $.fn.jquery);
});

// شغّل Alpine في النهاية
Alpine.start();

// تسجيل Service Worker للتحديثات المستقبلية (اختياري)
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function () {
    navigator.serviceWorker.register('/sw.js').then(
      function (registration) {
        console.log('Service Worker مسجّل بنجاح مع النطاق:', registration.scope);
      },
      function (err) {
        console.log('فشل تسجيل Service Worker:', err);
      }
    );
  });
}