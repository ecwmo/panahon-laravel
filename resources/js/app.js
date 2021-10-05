import { createApp } from 'vue';

import StationForm from './components/StationForm.vue';
import StationTable from './components/StationTable.vue';
import UserForm from './components/UserForm.vue';
import UserTable from './components/UserTable.vue';
import RoleTable from './components/RoleTable.vue';
import RoleForm from './components/RoleForm.vue';

const app = createApp({});
app.component('station-table', StationTable);
app.component('station-form', StationForm);
app.component('user-form', UserForm);
app.component('user-table', UserTable);
app.component('role-table', RoleTable);
app.component('role-form', RoleForm);
app.mount('#app');
