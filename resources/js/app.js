import { createApp } from 'vue';

import Header from './components/Header.vue';
import StationDefault from './views/StationDefault.vue';
import StationForm from './views/StationForm.vue';
import UserDefault from './views/UserDefault.vue';
import UserForm from './views/UserForm.vue';
import RoleDefault from './views/RoleDefault.vue';
import RoleForm from './views/RoleForm.vue';

const app = createApp({});
app.component('v-header', Header);
app.component('station-default', StationDefault);
app.component('station-form', StationForm);
app.component('user-default', UserDefault);
app.component('user-form', UserForm);
app.component('role-default', RoleDefault);
app.component('role-form', RoleForm);
app.mount('#app');
