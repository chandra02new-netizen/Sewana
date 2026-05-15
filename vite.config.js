import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/css/auth.css',
                'resources/css/breeze.css',
                'resources/css/landing.css',
                'resources/css/admin.css',
                'resources/css/admin/page-components.css',
                'resources/css/admin/dashboard.css',
                'resources/css/admin/products.css',
                'resources/css/admin/orders.css',
            ],
            refresh: true,
        }),
    ],
});
