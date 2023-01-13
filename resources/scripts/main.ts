import '../styles/app.css'

import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, DefineComponent, h } from 'vue'

import { createPinia } from 'pinia'

//@ts-ignore
import { ZiggyVue } from 'ziggy'

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
  setup({ el, app, props, plugin }) {
    const VueApp = createApp({ render: () => h(app, props) })

    VueApp.use(plugin).use(createPinia()).use(ZiggyVue).mount(el)
  },
})
