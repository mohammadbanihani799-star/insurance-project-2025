import cssnano from 'cssnano';

export default {
    plugins: {
        tailwindcss: {},           // ✅ معالج Tailwind CSS
        autoprefixer: {},          // ✅ إضافة prefixes تلقائياً للمتصفحات
        'postcss-discard-charset': {}, // ✅ إزالة @charset من CSS
        // ✅ تقليل حجم CSS وإزالة الكود غير المستخدم
        ...(process.env.NODE_ENV === 'production' ? {
            cssnano: cssnano({
                preset: ['default', {
                    discardComments: { removeAll: true },
                    normalizeWhitespace: true,
                    minifySelectors: true,
                    minifyParams: true,
                }]
            })
        } : {})
    },
};
