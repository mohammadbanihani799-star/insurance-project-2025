import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',  // ✅ ملفات Blade
        './resources/js/**/*.js',            // ✅ ملفات JS
        './resources/css/**/*.css',          // ✅ ملفات CSS
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Tajawal', 'Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                arabic: ['Tajawal', 'sans-serif'],  // ✅ خط عربي
                latin: ['Inter', 'Figtree', 'sans-serif'],
            },
            colors: {
                bcare: {
                    primary: '#146394',
                    secondary: '#1a7ab8',
                    accent: '#0d4d73',
                    light: '#e6f2f8',
                },
            },
        },
    },

    plugins: [forms],
};
