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
} from '@fortawesome/free-solid-svg-icons'
import { dom } from '@fortawesome/fontawesome-svg-core'

import { createApp } from 'vue'

import '../styles/app.scss'

import Header from '@/components/Header.vue'
import Sidebar from '@/components/Sidebar.vue'
import StationDefault from '@/views/StationDefault.vue'
import StationForm from '@/views/StationForm.vue'
import StationLogs from '@/views/StationLogs.vue'
import UserDefault from '@/views/UserDefault.vue'
import UserForm from '@/views/UserForm.vue'
import RoleDefault from '@/views/RoleDefault.vue'
import RoleForm from '@/views/RoleForm.vue'

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
  faCheck
)
dom.watch()

const app = createApp({})
//@ts-ignore
app.component('font-awesome-icon', FontAwesomeIcon)
app.component('v-header', Header)
app.component('v-sidebar', Sidebar)
app.component('station-default', StationDefault)
app.component('station-form', StationForm)
app.component('station-logs', StationLogs)
app.component('user-default', UserDefault)
app.component('user-form', UserForm)
app.component('role-default', RoleDefault)
app.component('role-form', RoleForm)
app.mount('#app')
