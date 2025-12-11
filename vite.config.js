import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Añade el archivo a la lista de entrada (input)
            input: [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/js/validators.js' // <-- Añadido
            ],
            refresh: true,
        }),
    ],
});
