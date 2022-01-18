<template>
    <div class="w-max flex flex-col space-y-2 items-center mx-auto">
        <div class="w-full flex justify-between items-end p-2">
            <h2 class="text-2xl">Station <span class="font-bold">Details</span></h2>
            <div class="flex">
                <!--    <div class="flex">
                    <form action="{{ route('stations.index') }}" method="GET" role="search">
                        <div class="input-group">
                            <button
                                class="rounded px-3 py-2 m-1 shadow-lg bg-blue-500 border-blue-600"
                                type="submit"
                                title="Search stations"
                            >
                                <i class="fas fa-search"></i>
                            </button>
                            <input
                                type="text"
                                class="rounded px-3 py-2 shadow-lg mr-2"
                                name="q"
                                placeholder="Search stations"
                                id="q"
                            />
                        </div>
                    </form>
                </div>
                <a
                    href="{{ route('stations.index') }}"
                    class="rounded px-3 py-2 m-1 shadow-lg bg-red-500 border-red-600"
                >
                    <i class="fas fa-sync-alt"></i>
                </a> -->
                <a
                    v-if="isAdmin"
                    class="rounded px-3 py-2 m-1 shadow-lg bg-blue-600 border-blue-700"
                    :href="`${baseUrl}/create`"
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
            @itemDeleteConfirm="handleItemDeleteConfirm"
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
    emits: ['itemDeleted'],
    components: { DataTable },
    setup(props) {
        const tableData = ref([]);

        const { fetchUrl, baseUrl } = toRefs(props);

        const fetchData = async (url) => {
            if (url) {
                const dat = await axios.get(url).then(({ data: d }) => d);

                const newDat = dat.data.map((d) => ({
                    ...d,
                    statusUrl: `${baseUrl.value}/${d.id}/logs`,
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
                            href: '#',
                            emit: 'itemDeleteConfirm',
                            modalMessage: `delete '${d.name}' station?`,
                            btnClassName: 'fas fa-trash',
                        },
                    ],
                }));

                tableData.value = {
                    ...dat,
                    data: newDat,
                    columns: [
                        { name: 'name', title: 'Name' },
                        { name: 'address', title: 'Address' },
                        { name: 'station_type', title: 'Type' },
                        { name: 'status', title: 'Status', href: 'statusUrl' },
                        { name: 'date_installed', title: 'Install Date' },
                    ],
                };
            }
        };

        const handleItemDeleteConfirm = (delId) =>
            axios.delete(`${baseUrl.value}/${delId}`).then(() => {
                const newDat = tableData.value.data.filter(({ id }) => id !== delId);
                tableData.value = { ...tableData.value, data: newDat };
            });

        onMounted(() => fetchData(fetchUrl.value));

        return {
            tableData,
            fetchData,
            handleItemDeleteConfirm,
        };
    },
};
</script>
