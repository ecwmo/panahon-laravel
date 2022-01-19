<template>
    <div class="w-max flex flex-col space-y-2 items-center mx-auto">
        <div class="w-full flex justify-between items-end p-2">
            <h2 class="text-2xl">User <span class="font-bold">Details</span></h2>
            <div class="flex">
                <a
                    v-if="isAdmin"
                    class="rounded px-3 py-2 m-1 shadow-lg bg-blue-600 border-blue-700"
                    href="{{ route('users.create') }}"
                    role="button"
                >
                    <i class="fa fa-plus"></i
                ></a>
            </div>
        </div>

        <DataTable
            class="w-full"
            :data="tableData"
            :showAction="isAdmin"
            @fetchData="fetchData"
            @modalBtnClick="handleModalBtnClick"
        >
        </DataTable>
    </div>
</template>

<script>
import { ref, toRefs, onMounted } from 'vue';
import axios from 'axios';

import DataTable from '../components/DataTable.vue';

export default {
    props: {
        fetchUrl: { type: String, required: true },
        baseUrl: { type: String, required: true },
        isAdmin: { type: Boolean, default: false },
    },
    components: { DataTable },
    setup(props) {
        const tableData = ref([]);

        const { fetchUrl, baseUrl } = toRefs(props);

        const fetchData = async (url) => {
            if (url) {
                const dat = await axios.get(url).then(({ data: d }) => d);

                const newDat = dat.data.map((d) => ({
                    ...d,
                    action: [
                        {
                            className: 'stroke-current hover:text-blue-600',
                            title: 'Edit',
                            href: `${baseUrl.value}/${d.id}/edit`,
                            btnClassName: 'fas fa-edit',
                        },
                        {
                            className: 'stroke-current hover:text-red-600',
                            title: 'Delete',
                            type: 'delete',
                            modalMessage: `delete '${d.name}' user?`,
                            btnClassName: 'fas fa-trash',
                        },
                    ],
                }));

                tableData.value = {
                    ...dat,
                    data: newDat,
                    columns: [
                        { name: 'name', title: 'Name' },
                        { name: 'roleList', title: 'Roles' },
                    ],
                };
            }
        };

        const handleModalBtnClick = (ev) => {
            if (ev.type === 'delete')
                axios.delete(`${baseUrl.value}/${ev.id}`).then(() => {
                    const { current_page: curPage, links, data } = tableData.value;
                    const curLink = links.find(({ label }) => `${curPage}` === label);
                    const url = data.length === 1 ? fetchUrl.value : curLink.url;
                    fetchData(url);
                });
        };

        onMounted(() => fetchData(fetchUrl.value));

        return {
            tableData,
            fetchData,
            handleModalBtnClick,
        };
    },
};
</script>
