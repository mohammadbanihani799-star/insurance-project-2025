import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import compression from 'vite-plugin-compression';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                'resources/views/**/*.blade.php',
                'routes/**/*.php',
            ],
        }),
        // Gzip compression for production
        compression({
            verbose: true,
            disable: false,
            threshold: 10240, // Only compress files > 10KB
            algorithm: 'gzip',
            ext: '.gz',
        }),
        // Brotli compression for modern browsers
        compression({
            verbose: true,
            disable: false,
            threshold: 10240,
            algorithm: 'brotliCompress',
            ext: '.br',
        }),
    ],

    // CSS Configuration - uses postcss.config.js
    css: {
        devSourcemap: false,
    },

    // Development Server
    server: {
        https: false,
        host: true, // Listen on all addresses (0.0.0.0)
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
        cors: true, // Enable CORS
        origin: 'http://localhost:8000',
    },

    // Build Configuration
    build: {
        manifest: true,
        outDir: 'public/build',
        sourcemap: false, // Disable source maps to prevent ERR_BLOCKED_BY_CLIENT
        minify: 'terser', // Use terser for better minification
        cssMinify: true,
        cssCodeSplit: true, // Enable CSS code splitting for better performance
        terserOptions: {
            compress: {
                drop_console: true, // Remove console logs in production
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info', 'console.debug'],
            },
            format: {
                comments: false, // Remove comments
            },
        },
        rollupOptions: {
            output: {
                // Manual chunks for vendor splitting (better caching)
                manualChunks: {
                    'vendor': ['axios', 'alpinejs'],
                    'bootstrap': ['bootstrap', '@popperjs/core'],
                    'jquery': ['jquery'],
                    'ui-libs': ['@fancyapps/ui', 'slick-carousel', 'aos'],
                },
                sourcemap: false, // Double ensure no source maps
                // Optimize chunk file names
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
                assetFileNames: 'assets/[ext]/[name]-[hash].[ext]',
                // Compact output
                compact: true,
            },
        },
        // Improve build performance
        chunkSizeWarningLimit: 1000,
        reportCompressedSize: false,
    },
});
