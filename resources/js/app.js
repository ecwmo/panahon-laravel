import { createApp } from 'vue';

import Header from './components/Header.vue';
import DataTable from './components/DataTable.vue';
import StationForm from './components/StationForm.vue';
import UserForm from './components/UserForm.vue';
import RoleForm from './components/RoleForm.vue';

const app = createApp({});
app.component('v-header', Header);
app.component('data-table', DataTable);
app.component('station-form', StationForm);
app.component('user-form', UserForm);
app.component('role-form', RoleForm);
app.mount('#app');
