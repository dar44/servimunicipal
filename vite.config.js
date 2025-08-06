import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/password.js',
                'resources/js/image_preview.js',
            ],
            refresh: true,
        }),
    ],
});
