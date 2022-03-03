import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig(({ command }) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: false,
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.js',
        },
    },
    plugins: [
        vue(),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        },
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    optimizeDeps: {
        include: ['axios', 'vue'],
    },
}));
