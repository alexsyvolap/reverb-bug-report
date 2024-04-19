import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/echo.js', 'resources/css/filament/theme.css'],
            refresh: true,
        }),
    ],
});
