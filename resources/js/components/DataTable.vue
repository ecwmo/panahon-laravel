<template>
    <div>
        <table class="space-y-6 text-sm">
            <thead>
                <tr class="text-center">
                    <th v-if="showIdColumn" class="p-2 border border-gray-300" scope="col">#</th>
                    <th
                        v-for="col in columns"
                        :key="col.name"
                        class="p-2 border border-gray-300"
                        scope="col"
                    >
                        {{ col.title }}
                    </th>
                    <th v-if="showAction" class="p-2 border border-gray-300" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="td in tabledata" :key="td.id">
                    <td v-if="showIdColumn" class="p-2 text-justify border border-gray-300">
                        {{ td.id }}
                    </td>
                    <td
                        v-for="col in columns"
                        :key="col.name"
                        class="p-2 text-justify border border-gray-300"
                    >
                        {{ td[col.name] }}
                    </td>
                    <td v-if="showAction" class="p-2 text-center border border-gray-300 space-x-2">
                        <a
                            class="stroke-current hover:text-blue-600"
                            title="Edit"
                            :href="`${baseUrl}/${td.id}/edit`"
                        >
                            <i class="fas fa-edit"></i>
                        </a>
                        <a
                            class="stroke-current hover:text-red-600"
                            title="Delete"
                            href="#"
                            @click.prevent="(showModal = true), (activeId = td.id)"
                            ><i class="fas fa-trash"></i
                        ></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <Modal
            v-if="showModal"
            @close="showModal = false"
            :message="deleteModalMessage"
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
    props: {
        fetchUrl: { type: String, required: true },
        baseUrl: { type: String, required: true },
        columns: { required: true },
        showIdColumn: { type: Boolean, default: true },
        showAction: { type: Boolean, default: false },
        deleteModalMessage: { type: String, required: true },
    },
    components: {
        Modal,
    },
    setup(props) {
        const data = ref({});
        const tabledata = ref([]);
        const showModal = ref(false);
        const activeId = ref();

        const { fetchUrl, baseUrl } = toRefs(props);

        const closeModal = () => (showModal.value = false);

        const handleButtonClick = () => {
            axios.delete(`${baseUrl.value}/${activeId.value}`).then(() => {
                tabledata.value = tabledata.value.filter(({ id }) => id !== activeId.value);
                closeModal();
            });
        };

        const fetchData = async () => {
            data.value = await axios.get(fetchUrl.value).then(({ data: d }) => d);
            tabledata.value = data.value.data;
        };

        onMounted(() => {
            fetchData();
        });

        return { tabledata, activeId, showModal, closeModal, handleButtonClick };
    },
};
</script>
