/**
 * BCare Passive Event Listeners Fix
 * حل مشكلة تحذيرات "Added non-passive event listener" في Console
 *
 * هذا الملف يضيف passive listeners لجميع أحداث اللمس والتمرير
 * لتحسين أداء الصفحة وإزالة التحذيرات
 *
 * التثبيت: أضف هذا الكود في نهاية ملف app.js الخاص بك
 * أو استورده: import './passive-listeners';
 */

(function() {
    'use strict';

    /**
     * Override addEventListener لإضافة passive: true تلقائياً
     * لأحداث اللمس والتمرير
     */
    if (typeof EventTarget !== 'undefined') {
        const originalAddEventListener = EventTarget.prototype.addEventListener;

        // أحداث اللمس والتمرير التي يجب أن تكون passive
        const passiveEvents = [
            'touchstart',
            'touchmove',
            'touchend',
            'touchcancel',
            'wheel',
            'mousewheel',
            'scroll'
        ];

        EventTarget.prototype.addEventListener = function(type, listener, options) {
            // تحقق إذا كان الحدث من الأحداث التي يجب أن تكون passive
            if (passiveEvents.indexOf(type) !== -1) {
                // إذا كانت options عبارة عن boolean، حولها لـ object
                if (typeof options === 'boolean') {
                    options = {
                        capture: options,
                        passive: true
                    };
                }
                // إذا كانت options عبارة عن object
                else if (typeof options === 'object' && options !== null) {
                    // إضافة passive: true إلا إذا كانت محددة صراحة بـ false
                    if (options.passive === undefined) {
                        options.passive = true;
                    }
                }
                // إذا لم يتم تمرير options، اجعلها passive
                else if (options === undefined) {
                    options = { passive: true };
                }
            }

            // استدعاء الدالة الأصلية
            return originalAddEventListener.call(this, type, listener, options);
        };
    }

    /**
     * Fix خاص بـ jQuery
     * jQuery لا يدعم passive listeners بشكل افتراضي
     */
    if (typeof jQuery !== 'undefined' || typeof $ !== 'undefined') {
        const jq = jQuery || $;

        // حفظ النسخة الأصلية من jQuery.event.add
        const originalJQueryEventAdd = jq.event.add;

        jq.event.add = function(elem, types, handler, data, selector) {
            // تحقق إذا كان الحدث من أحداث اللمس
            const passiveEvents = ['touchstart', 'touchmove', 'wheel', 'mousewheel'];
            const typeArray = types.split(' ');

            typeArray.forEach(function(type) {
                // إزالة namespaces من اسم الحدث
                const eventType = type.split('.')[0];

                if (passiveEvents.indexOf(eventType) !== -1) {
                    // إضافة passive listener مباشرة عبر DOM API
                    if (elem && elem.addEventListener) {
                        const passiveHandler = function(e) {
                            handler.call(elem, e);
                        };
                        elem.addEventListener(eventType, passiveHandler, { passive: true });

                        // تخزين المرجع للإزالة لاحقاً إذا لزم الأمر
                        if (!elem._passiveHandlers) {
                            elem._passiveHandlers = {};
                        }
                        elem._passiveHandlers[eventType] = passiveHandler;
                    }
                }
            });

            // استدعاء الدالة الأصلية
            return originalJQueryEventAdd.call(this, elem, types, handler, data, selector);
        };
    }

    /**
     * Fix خاص بـ Slick Slider
     * إضافة passive listeners لأحداث Slick
     */
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.slick !== 'undefined') {
        // حفظ النسخة الأصلية من slick init
        const originalSlickInit = jQuery.fn.slick;

        jQuery.fn.slick = function(options) {
            // إضافة إعدادات passive للأحداث
            const defaultOptions = {
                touchMove: true,
                swipe: true,
                draggable: true
            };

            // دمج الإعدادات
            options = jQuery.extend({}, defaultOptions, options);

            // استدعاء slick الأصلي
            const result = originalSlickInit.call(this, options);

            // إضافة passive listeners للعنصر
            this.each(function() {
                const elem = this;
                const events = ['touchstart', 'touchmove', 'touchend'];

                events.forEach(function(eventType) {
                    if (elem.addEventListener) {
                        const existingHandler = elem['on' + eventType];
                        if (existingHandler) {
                            elem.removeEventListener(eventType, existingHandler);
                            elem.addEventListener(eventType, existingHandler, { passive: true });
                        }
                    }
                });
            });

            return result;
        };
    }

    console.log('✅ BCare Passive Listeners: تم تفعيل passive listeners بنجاح');

})();

/**
 * طريقة الاستخدام في app.js:
 *
 * // في نهاية ملف resources/js/app.js أضف:
 * import './passive-listeners';
 *
 * أو انسخ محتوى هذا الملف مباشرة في نهاية app.js
 */
