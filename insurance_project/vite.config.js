import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'style_files/frontend/js/main.js',
            ],
            refresh: true,
        }),
    ],


    server: process.env.NODE_ENV === 'development' ? { 
        https: false, 
        host: 'localhost', 
        port: 5173, // Adjust this to your Vite development port
    } : undefined,
    




        base: process.env.NODE_ENV === 'production' ? '/style_files/frontend/' : '/',
        // other Vite configurations...
      
});
