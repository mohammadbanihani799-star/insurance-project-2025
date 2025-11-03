
/*   first slider in home  */
(function ($) {
    'use strict';

    function initSlickOnce($el, options) {
        if (!$el.length || $el.hasClass('slick-initialized')) return;
        $el.slick(options);
    }

    $(function () {
        initSlickOnce($('.main_slider'), {
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
            arrows: false,
            dotsClass: 'main-dots', // اسم فريد
            autoplay: true,
            autoplaySpeed: 2000,
            customPaging: function (slider, i) {
                // Display only 4 dots
                if (i < 4) {
                    return '<span class="dot"></span>';
                }
                return '';
            },
        });

        // Set the active class on the first dot by default
        $('.main-dots .dot').eq(0).addClass('active');

        $(document).on('click', '.main-dots .dot', function () {
            $('.main-dots .dot').removeClass('active');
            $(this).addClass('active');
        });

        $('.main_slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            $('.main-dots .dot').removeClass('active');
            $('.main-dots .dot').eq(Math.min(nextSlide, 3)).addClass('active');
        });

    });

})(window.jQuery);
/*   first slider in home  */







/*  main menu script - Bootstrap 5 + Slick  */
// تبويبات + سلايدر داخل التبويبات (Bootstrap 5)
document.addEventListener('DOMContentLoaded', function () {
    // فعّل أول تبويب
    const firstTabEl = document.querySelector('#myTabs1 .nav-item:first-child a[data-bs-toggle="tab"]');
    if (firstTabEl && typeof bootstrap !== 'undefined') {
        new bootstrap.Tab(firstTabEl).show();
    }

    function initSlickOnce($el, options) {
        if (!$el.length || $el.hasClass('slick-initialized')) return;
        $el.slick(options);
    }

    // فعّل slick في أول تبويب فورًا
    initSlickOnce($('.tab-content #tab1 .cars_slider'), {
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1500
    });

    // عند إظهار أي تبويب
    document.querySelectorAll('#myTabs1 a[data-bs-toggle="tab"]').forEach((el) => {
        el.addEventListener('shown.bs.tab', (e) => {
            const target = e.target.getAttribute('href');
            const $slider = $(target + ' .cars_slider');
            initSlickOnce($slider, {
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 1500
            });
            // إصلاح الأبعاد بعد الظهور
            if ($slider.hasClass('slick-initialized')) {
                $slider.slick('setPosition');
            }
        });
    });
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










// سلايدر الشركات
(function ($) {
    'use strict';

    function initSlickOnce($el, options) {
        if (!$el.length || $el.hasClass('slick-initialized')) return;
        $el.slick(options);
    }

    $(function () {
        initSlickOnce($('.componies_wrapper'), {
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            dots: true,
            arrows: false,
            dotsClass: 'companies-dots', // اسم فريد
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ],
            customPaging: function () {
                return '<span class="dot"></span>';
            },
        });
    });

})(window.jQuery);



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
// أزرار المهام
(function ($) {
    'use strict';

    $(function () {
        $(document).on('click', '.listBtn', function () {
            $('.listBtn').removeClass('active');
            $(this).addClass('active');
        });
    });

})(window.jQuery);
/************* tasks script **************/

