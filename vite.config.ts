import { resolve } from 'path'
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

import vue from '@vitejs/plugin-vue'
import inertia from './resources/scripts/vite/inertia-layout'

import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'

export default defineConfig({
  plugins: [
    inertia(),
    laravel(['resources/scripts/main.ts']),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    AutoImport({
      imports: ['vue', { '@inertiajs/inertia-vue3': ['usePage', 'useForm'] }],
      dts: 'resources/scripts/auto-imports.d.ts',
      dirs: ['resources/scripts/composables', 'resources/scripts/store'],
      vueTemplate: true,
    }),
    Components({
      dirs: ['resources/scripts/components'],
      dts: 'resources/scripts/components.d.ts',
      directoryAsNamespace: true,
    }),
  ],
  resolve: {
    alias: {
      '@': resolve('resources'),
    },
  },
})
