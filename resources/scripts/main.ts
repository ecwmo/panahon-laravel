import '../styles/app.css'

import { DefineComponent, createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon, FontAwesomeIconProps } from '@fortawesome/vue-fontawesome'
import {
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
  faSignal,
} from '@fortawesome/free-solid-svg-icons'
import { dom } from '@fortawesome/fontawesome-svg-core'

//@ts-ignore
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

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
      .use(ZiggyVue)
      .mount(el)
  },
})
