// ============================================================================
// 🎯 Main Slider - RTL + Mobile-First + منع التمرير الأفقي
// ============================================================================
$(document).ready(function () {
    $('.main_slider').slick({
        rtl: document.documentElement.getAttribute('dir') === 'rtl', // دعم RTL تلقائي
        mobileFirst: true,                // موبايل أولاً
        adaptiveHeight: true,             // منع فجوات عمودية
        swipeToSlide: true,               // سحب طبيعي وسلس
        touchThreshold: 8,                // حساسية اللمس متوازنة
        edgeFriction: 0.15,               // تقليل "قفزة الحافة"
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        dotsClass: 'custom-dots',
        autoplay: true,
        autoplaySpeed: 2000,
        customPaging: function (slider, i) {
            return '<span class="dot"></span>'; // عدد تلقائي للنقاط
        },
    });

    // تفعيل النقطة الأولى افتراضياً
    $('.custom-dots .dot').eq(0).addClass('active');

    // النقر على النقاط (مع namespace لمنع التكرار)
    $(document).off('click.mainDots').on('click.mainDots', '.custom-dots .dot', function () {
        $('.custom-dots .dot').removeClass('active');
        $(this).addClass('active');
    });

    // مزامنة النقطة النشطة مع السلايد
    $('.main_slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        const $dots = $('.custom-dots .dot');
        $dots.removeClass('active');
        $dots.eq(nextSlide % $dots.length).addClass('active'); // يدعم أي عدد
    });
});

/*   first slider in home  */







// ============================================================================
// 🚗 Tab Cars Slider - RTL + إصلاح الأبعاد عند تبديل التبويبات
// ============================================================================
$(document).ready(function () {
    // دالة مساعدة لتهيئة سلايدر واحد فقط
    function initCarsSlider($container) {
        const $slider = $container.find('.cars_slider');
        if ($slider.length && !$slider.hasClass('slick-initialized')) {
            $slider.slick({
                rtl: document.documentElement.getAttribute('dir') === 'rtl',
                mobileFirst: true,
                adaptiveHeight: true,
                swipeToSlide: true,
                touchThreshold: 8,
                edgeFriction: 0.15,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 1500,
            });
        } else if ($slider.hasClass('slick-initialized')) {
            // إصلاح الأبعاد بعد ظهور التبويب (مهم!)
            $slider.slick('setPosition');
        }
    }

    // تهيئة التبويب الأول عند التحميل
    initCarsSlider($('#tab1'));

    // عند تبديل التبويبات (Bootstrap 5 API)
    const tabTriggers = document.querySelectorAll('#myTabs1 a[data-bs-toggle="tab"]');
    tabTriggers.forEach(function(trigger) {
        trigger.addEventListener('shown.bs.tab', function(e) {
            const targetTabId = e.target.getAttribute('href');
            initCarsSlider($(targetTabId));
        });
    });

    // تفعيل التبويب الأول (Bootstrap 5 API)
    const firstTab = document.querySelector('#myTabs1 .nav-item:first-child a');
    if (firstTab && window.bootstrap) {
        const tab = new window.bootstrap.Tab(firstTab);
        tab.show();
    } else if (firstTab && $.fn.tab) {
        // Fallback للـ jQuery plugin إذا كان موجود
        $(firstTab).tab('show');
    }
});








// $(document).ready(function () {

//     $('.slider-for').slick({
//         slidesToShow: 1,
//         slidesToScroll: 1,
//         arrows: false,
//         draggable: false,
//         autoplay: false,
//         //   fade: true,
//         asNavFor: '.slider-nav',
//         responsive: [{
//             breakpoint: 480,
//             settings: {
//                 slidesToShow: 1,
//                 arrows: true,
//             }
//         }]
//     });
//     $('.slider-nav').slick({
//         slidesToShow: 3,
//         slidesToScroll: 1,
//         asNavFor: '.slider-for',
//         //   dots: true,
//         //   centerMode: true,
//         focusOnSelect: true,


//         arrows: false,
//         draggable: false,
//         autoplay: false,
//         responsive: [{
//             breakpoint: 768,
//             settings: {
//                 slidesToShow: 2,
//             }
//         },
//         {
//             breakpoint: 480,
//             settings: {
//                 slidesToShow: 1,
//             }
//         }
//         ]
//     });

// });










// ============================================================================
// 🏢 Companies/Partners - DISABLED (Using CSS Grid instead of Slick)
// ============================================================================
$(document).ready(function () {
    // ❌ DISABLED: Slick Carousel for partners section
    // الآن نستخدم CSS Grid (.partners-grid-9) بدلاً من Slick Carousel
    // هذا يحسن الأداء ويقلل JavaScript المطلوب

    /* COMMENTED OUT - Old Slick implementation:
    $('.componies_wrapper').slick({
        rtl: document.documentElement.getAttribute('dir') === 'rtl',
        mobileFirst: true,
        adaptiveHeight: false,
        swipeToSlide: true,
        touchThreshold: 8,
        edgeFriction: 0.15,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        dotsClass: 'custom-dots',
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    infinite: true,
                    dots: true
                }
            }
        ],
        customPaging: function (slider, i) {
            return '<span class="dot"></span>';
        },
    });
    */

    console.log('Partners section: Using CSS Grid instead of Slick Carousel');
});



//  $(document).ready(function () {

//  $('.responsive').slick({
//   dots: true,
//   infinite: false,
//   speed: 300,
//   slidesToShow: 4,
//   slidesToScroll: 4,
//   responsive: [
//     {
//       breakpoint: 1024,
//       settings: {
//         slidesToShow: 3,
//         slidesToScroll: 3,
//         infinite: true,
//         dots: true
//       }
//     },
//     {
//       breakpoint: 600,
//       settings: {
//         slidesToShow: 2,
//         slidesToScroll: 2
//       }
//     },
//     {
//       breakpoint: 480,
//       settings: {
//         slidesToShow: 1,
//         slidesToScroll: 1
//       }
//     }
//     // You can unslick at a given breakpoint now by adding:
//     // settings: "unslick"
//     // instead of a settings object
//   ]
// });




//  });









/************* tasks script **************/
$(document).ready(function() {
    $('.listBtn').click(function() {
        // Remove the 'active' class from all buttons
        $('.listBtn').removeClass('active');

        // Add the 'active' class only to the clicked button
        $(this).addClass('active');
    });
});

/************* tasks script **************/

// ============================================================================
// 🔧 إصلاح تحذير non-passive touch listeners
// ============================================================================
$(document).ready(function() {
    // إضافة passive listeners لتقليل التحذيرات
    document.querySelectorAll('.slick-list').forEach(el => {
        el.addEventListener('touchstart', () => {}, { passive: true });
        el.addEventListener('touchmove', () => {}, { passive: true });
    });

    // مراقبة إضافة Slick جديدة ديناميكياً
    const observer = new MutationObserver(() => {
        document.querySelectorAll('.slick-list').forEach(el => {
            if (!el.dataset.passiveAdded) {
                el.addEventListener('touchstart', () => {}, { passive: true });
                el.addEventListener('touchmove', () => {}, { passive: true });
                el.dataset.passiveAdded = 'true';
            }
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });
});

