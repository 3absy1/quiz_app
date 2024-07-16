import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base: '/',

    plugins: [
        laravel({
            input: [

                'resources/js/app.js',
                'resources/css/app.css',
                'Modules/GoogleFormsModule/resources/assets/js/app.js',


                'Modules/GoogleFormsModule/resources/src/main.js',
            ],

            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    build: {
        outDir: 'public/build', // Adjust this path based on your project structure
        rollupOptions: {
            // Make sure to include 'alpinejs' in the external option
            external: ['alpinejs'],
          },
      },

});

