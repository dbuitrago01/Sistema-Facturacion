import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // solo JS, que importa CSS
            refresh: true,
            buildDirectory: 'vite', // manifest dentro de public/build/vite
        }),
    ],
    base: '/',
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            input: ['resources/js/app.js'],
        },
    },
});
