import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { dom } from '@fortawesome/fontawesome-svg-core';

import { createApp } from 'vue';

import '../sass/app.scss';

import Header from './components/Header.vue';
import StationDefault from './views/StationDefault.vue';
import StationForm from './views/StationForm.vue';
import UserDefault from './views/UserDefault.vue';
import UserForm from './views/UserForm.vue';
import RoleDefault from './views/RoleDefault.vue';
import RoleForm from './views/RoleForm.vue';

library.add(fas);
library.add(far);
dom.watch();

const app = createApp({});
app.component('font-awesome-icon', FontAwesomeIcon);
app.component('v-header', Header);
app.component('station-default', StationDefault);
app.component('station-form', StationForm);
app.component('user-default', UserDefault);
app.component('user-form', UserForm);
app.component('role-default', RoleDefault);
app.component('role-form', RoleForm);
app.mount('#app');
