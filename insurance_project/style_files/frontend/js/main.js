// ============================================================================
// main.js - النسخة الموحّدة والمحسّنة
// ============================================================================
// ✅ إزالة تكرار initSlickOnce (دالة واحدة للجميع)
// ✅ متوافق مع Bootstrap 5 (data-bs-toggle + bootstrap.Tab API)
// ✅ فصل dotsClass لكل سلايدر (main-dots / companies-dots)
// ✅ حماية من التهيئة المزدوجة لـ Slick
// ============================================================================

(function ($) {
  'use strict';

  // ===== Helper Function: تهيئة Slick مرة واحدة فقط =====
  function initSlickOnce($el, options) {
    if (!$el.length || $el.hasClass('slick-initialized')) return;
    $el.slick(options);
  }

  // =========================================================================
  // 1️⃣ السلايدر الرئيسي (Main Slider)
  // =========================================================================
  $(function () {
    initSlickOnce($('.main_slider'), {
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      arrows: false,
      dotsClass: 'main-dots', // اسم فريد للنقاط
      autoplay: true,
      autoplaySpeed: 2000,
      customPaging: function (_slider, i) {
        // عرض 4 نقاط فقط
        return i < 4 ? '<span class="dot"></span>' : '';
      },
    });

    // تفعيل النقطة الأولى افتراضيًا
    $('.main-dots .dot').eq(0).addClass('active');

    // عند النقر على النقاط
    $(document).on('click', '.main-dots .dot', function () {
      $('.main-dots .dot').removeClass('active');
      $(this).addClass('active');
    });

    // مزامنة النقطة النشطة مع السلايد الحالي
    $('.main_slider').on('beforeChange', function (_e, _slick, _cur, next) {
      $('.main-dots .dot').removeClass('active');
      $('.main-dots .dot').eq(Math.min(next, 3)).addClass('active');
    });
  });

  // =========================================================================
  // 2️⃣ التبويبات + السلايدرات داخلها (Bootstrap 5 + Slick)
  // =========================================================================
  document.addEventListener('DOMContentLoaded', function () {
    // تفعيل أول تبويب باستخدام Bootstrap 5 API
    const firstTabEl = document.querySelector('#myTabs1 .nav-item:first-child a[data-bs-toggle="tab"]');
    if (firstTabEl && typeof bootstrap !== 'undefined') {
      new bootstrap.Tab(firstTabEl).show();
    }

    // تهيئة السلايدر في التبويب الأول مباشرة
    $(function () {
      initSlickOnce($('.tab-content #tab1 .cars_slider'), {
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1500,
      });
    });

    // عند التبديل بين التبويبات
    const tabLinks = document.querySelectorAll('#myTabs1 a[data-bs-toggle="tab"]');
    tabLinks.forEach((el) => {
      el.addEventListener('shown.bs.tab', (e) => {
        const target = e.target.getAttribute('href'); // مثل: #tab2
        const $slider = $(target + ' .cars_slider');

        // تهيئة السلايدر إن لم يكن مُهيّأ
        initSlickOnce($slider, {
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: false,
          autoplay: true,
          autoplaySpeed: 1500,
        });

        // إصلاح الأبعاد بعد ظهور التبويب
        if ($slider.hasClass('slick-initialized')) {
          $slider.slick('setPosition');
        }
      });
    });
  });

  // =========================================================================
  // 3️⃣ سلايدر الشركات (Companies Slider) - ❌ DISABLED - Using CSS Grid
  // =========================================================================
  // استخدام CSS Grid بدلاً من Slick للأداء الأفضل
  /*
  $(function () {
    initSlickOnce($('.componies_wrapper'), {
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 4,
      dots: true,
      arrows: false,
      dotsClass: 'companies-dots', // اسم فريد للنقاط
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: true,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
      customPaging: function () {
        return '<span class="dot"></span>';
      },
    });
  });
  */

  // =========================================================================
  // 4️⃣ أزرار المهام (Tasks Buttons)
  // =========================================================================
  $(function () {
    $(document).on('click', '.listBtn', function () {
      $('.listBtn').removeClass('active');
      $(this).addClass('active');
    });
  });

  // =========================================================================
  // 🐛 Debug: تحقق من تحميل المكتبات
  // =========================================================================
  console.log('jQuery:', typeof window.jQuery, $.fn && $.fn.jquery);
  console.log('Slick exists:', !!$.fn.slick);
  console.log('Bootstrap:', typeof window.bootstrap);



})(window.jQuery);
