import { viteStaticCopy } from 'vite-plugin-static-copy'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),

        viteStaticCopy({
            targets: [
                {
                    src: 'resources/css/animate.css',
                    dest: './assets/css/'
                },                 
                {
                    src: 'resources/css/tailwind.css',
                    dest: './assets/css/'
                }, 
                {
                    src: 'resources/js/main.js',
                    dest: './assets/js/'
                },
                {
                    src: 'resources/js/wow.min.js',
                    dest: './assets/js/'
                },                                                                                                                                                                                                                                                                                                                                                         
            ]
        })        
    ],
});
