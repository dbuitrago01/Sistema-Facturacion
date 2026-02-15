import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // Solo JS, que importa CSS
            refresh: true, // desarrollo
        }),
    ],
    base: '/',
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            input: ['resources/js/app.js'], // Solo JS
        },
    },
});
