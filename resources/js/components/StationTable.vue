<template>
    <div>
        <table class="space-y-6 text-sm">
            <thead>
                <tr class="text-center">
                    <th class="p-2 border border-gray-300" scope="col"></th>
                    <th class="p-2 border border-gray-300" scope="col">Name</th>
                    <th class="p-2 border border-gray-300" scope="col">Address</th>
                    <th class="p-2 border border-gray-300" scope="col">Type</th>
                    <th class="p-2 border border-gray-300" scope="col">Status</th>
                    <th class="p-2 border border-gray-300" scope="col">Install Date</th>
                    <th v-if="showAction" class="p-2 border border-gray-300" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="st in stations" :key="st.id">
                    <th class="p-2 text-justify border border-gray-300" scope="row">{{ st.id }}</th>
                    <td class="p-2 text-justify border border-gray-300">{{ st.name }}</td>
                    <td class="p-2 text-justify border border-gray-300">{{ st.address }}</td>
                    <td class="p-2 text-center border border-gray-300">{{ st.station_type }}</td>
                    <td class="p-2 text-center border border-gray-300">{{ st.status }}</td>
                    <td class="p-2 text-center border border-gray-300">
                        {{ st.date_installed }}
                    </td>
                    <td v-if="showAction" class="p-2 text-center border border-gray-300 space-x-2">
                        <a
                            class="stroke-current hover:text-blue-600"
                            title="Edit"
                            :href="`${baseUrl}/${st.id}/edit`"
                            ><i class="fas fa-edit"></i
                        ></a>
                        <a
                            class="stroke-current hover:text-red-600"
                            title="Delete"
                            href="#"
                            @click.prevent="(showModal = true), (activeId = st.id)"
                            ><i class="fas fa-trash"></i
                        ></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <Modal
            v-if="showModal"
            @close="showModal = false"
            :message="'Delete this station?'"
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
        const stations = ref([]);
        const showModal = ref(false);
        const activeId = ref();

        const { baseUrl, data } = toRefs(props);

        const closeModal = () => (showModal.value = false);

        const handleButtonClick = () => {
            axios.delete(`${baseUrl.value}/${activeId.value}`).then(() => {
                stations.value = stations.value.filter(({ id }) => id !== activeId.value);
                closeModal();
            });
        };

        onMounted(() => (stations.value = data.value.data));

        return { stations, activeId, showModal, closeModal, handleButtonClick };
    },
};
</script>
