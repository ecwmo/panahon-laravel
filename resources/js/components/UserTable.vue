<template>
    <div>
        <table class="space-y-6 text-sm">
            <thead>
                <tr class="text-center">
                    <th class="p-2 border border-gray-300" scope="col">Name</th>
                    <th class="p-2 border border-gray-300" scope="col">Roles</th>
                    <th v-if="showAction" class="p-2 border border-gray-300" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <th class="p-2 text-justify border border-gray-300" scope="row">
                        {{ user.name }}
                    </th>
                    <td class="p-2 text-justify border border-gray-300">{{ user.roleList }}</td>
                    <td v-if="showAction" class="p-2 text-center border border-gray-300 space-x-2">
                        <a
                            class="stroke-current hover:text-blue-600"
                            title="Edit"
                            :href="`${baseUrl}/${user.id}/edit`"
                            ><i class="fas fa-edit"></i
                        ></a>
                        <a
                            class="stroke-current hover:text-red-600"
                            title="Delete"
                            href="#"
                            @click.prevent="(showModal = true), (activeId = user.id)"
                            ><i class="fas fa-trash"></i
                        ></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <Modal
            v-if="showModal"
            @close="showModal = false"
            :message="'Delete this user?'"
            @btn-click="handleButtonClick"
        >
        </Modal>
    </div>
</template>

<script>
import { ref, toRefs, onMounted } from 'vue';
import axios from 'axios';

import Modal from './Modal.vue';
export default {
    props: ['data', 'baseUrl', 'showAction'],
    components: {
        Modal,
    },
    setup(props) {
        const users = ref([]);
        const showModal = ref(false);
        const activeId = ref();

        const { baseUrl, data } = toRefs(props);

        const closeModal = () => (showModal.value = false);

        const handleButtonClick = () => {
            axios.delete(`${baseUrl.value}/${activeId.value}`).then(() => {
                users.value = users.value.filter(({ id }) => id !== activeId.value);
                closeModal();
            });
        };

        onMounted(() => (users.value = data.value.data));

        return { users, activeId, showModal, closeModal, handleButtonClick };
    },
};
</script>
