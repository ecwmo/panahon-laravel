import '../styles/app.css'

import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, DefineComponent, h } from 'vue'

import { createPinia } from 'pinia'

import { dom, library } from '@fortawesome/fontawesome-svg-core'
import {
  faAdd,
  faBars,
  faCheck,
  faChevronDown,
  faChevronRight,
  faChevronUp,
  faEdit,
  faInfo,
  faSignal,
  faTachometerAlt,
  faTimes,
  faTrash,
  faUmbrella,
  faUser,
  faUserTag,
} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon, FontAwesomeIconProps } from '@fortawesome/vue-fontawesome'

//@ts-ignore
import { ZiggyVue } from 'ziggy'

library.add(
  faTachometerAlt,
  faUmbrella,
  faUser,
  faUserTag,
  faAdd,
  faEdit,
  faTrash,
  faTimes,
  faInfo,
  faChevronUp,
  faChevronDown,
  faChevronRight,
  faBars,
  faCheck,
  faSignal
)
dom.watch()

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
  setup({ el, app, props, plugin }) {
    const VueApp = createApp({ render: () => h(app, props) })

    VueApp
      // https://github.com/FortAwesome/vue-fontawesome/issues/295#issuecomment-823411585
      .component('font-awesome-icon', FontAwesomeIcon as unknown as DefineComponent<FontAwesomeIconProps>)
      .use(plugin)
      .use(createPinia())
      .use(ZiggyVue)
      .mount(el)
  },
})
