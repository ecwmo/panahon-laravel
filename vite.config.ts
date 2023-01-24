import laravel from 'laravel-vite-plugin'
import { resolve } from 'path'
import { defineConfig } from 'vite'
import InertiaLayout from './resources/scripts/vite/inertia-layout'

import vue from '@vitejs/plugin-vue'

import AutoImport from 'unplugin-auto-import/vite'
import IconsResolver from 'unplugin-icons/resolver'
import Icons from 'unplugin-icons/vite'
import Components from 'unplugin-vue-components/vite'

export default defineConfig({
  plugins: [
    InertiaLayout(),
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
      resolvers: [
        IconsResolver(),
        (componentName) => {
          if (componentName.startsWith('Inertia'))
            return { name: componentName.slice(7), from: '@inertiajs/inertia-vue3' }
          else if (componentName.startsWith('Proton'))
            return { name: componentName.slice(6), from: '@protonemedia/inertiajs-tables-laravel-query-builder' }
        },
      ],
      dirs: ['resources/scripts/components'],
      dts: 'resources/scripts/components.d.ts',
      directoryAsNamespace: true,
    }),
    Icons({}),
  ],
  resolve: {
    alias: {
      '@': resolve('resources/scripts'),
      ziggy: resolve('vendor/tightenco/ziggy/dist/vue.m'),
    },
  },
})
