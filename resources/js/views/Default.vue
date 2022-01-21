<template>
    <div class="w-max flex flex-col space-y-2 items-center mx-auto">
        <div class="w-full flex justify-between items-end p-2">
            <h2 class="text-2xl"><slot name="header"></slot></h2>
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
        formatData: { type: Function },
    },
    components: { DataTable },
    setup(props) {
        const tableData = ref([]);

        const { fetchUrl, baseUrl, formatData } = toRefs(props);

        const fetchData = async (url) => {
            if (url) {
                const dat = await axios.get(url).then(({ data: d }) => d);

                tableData.value = formatData.value ? formatData.value(dat) : dat;
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
