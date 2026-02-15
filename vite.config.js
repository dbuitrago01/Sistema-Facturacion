import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // Solo JS, que importa el CSS
            refresh: true,                 // útil para desarrollo
        }),
    ],
    base: '/',   // importante: usa rutas relativas para producción
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: ['resources/js/app.js'], // Solo JS, que importa el CSS
        },
    },
});
