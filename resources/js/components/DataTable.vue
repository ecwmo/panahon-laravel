<template>
    <div>
        <table class="table-auto space-y-6 text-sm mb-2">
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
        <Pagination v-if="showPagination" :data="data" @fetch-data="fetchData" />
        <Modal
            v-if="showModal"
            @close="showModal = false"
            :message="deleteModalMessage"
            @btn-click="handleButtonClick"
        />
    </div>
</template>

<script>
import { ref, toRefs, computed, onMounted } from 'vue';
import axios from 'axios';

import Pagination from './Pagination.vue';
import Modal from './Modal.vue';

export default {
    props: {
        fetchUrl: { type: String, required: true },
        baseUrl: { type: String, required: true },
        columns: { required: true },
        showIdColumn: { type: Boolean, default: true },
        showAction: { type: Boolean, default: false },
        deleteModalMessage: { type: String, default: 'Delete?' },
    },
    components: {
        Pagination,
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

        const fetchData = async (url) => {
            if (url) {
                data.value = await axios.get(url).then(({ data: d }) => d);
                tabledata.value = data.value.data;
            }
        };

        const showPagination = computed(
            () =>
                Object.prototype.hasOwnProperty.call(data.value, 'links') &&
                data.value.links.length > 3
        );

        onMounted(() => {
            fetchData(fetchUrl.value);
        });

        return {
            fetchData,
            data,
            tabledata,
            activeId,
            showModal,
            showPagination,
            closeModal,
            handleButtonClick,
        };
    },
};
</script>
