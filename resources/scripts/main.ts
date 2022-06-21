import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
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

import App from '@/App.vue'
import router from '@/router'
import { createPinia } from 'pinia'

import '../styles/app.scss'

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

const app = createApp(App)
//@ts-ignore
app.component('font-awesome-icon', FontAwesomeIcon)
app.use(router)
app.use(createPinia())
app.mount('#app')
