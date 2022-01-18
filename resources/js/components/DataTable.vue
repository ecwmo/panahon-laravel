<template>
    <div>
        <table class="table-auto space-y-6 text-sm mb-2">
            <thead>
                <tr class="text-center">
                    <th v-if="showIdColumn" class="p-2 border border-gray-300" scope="col">#</th>
                    <th
                        v-for="col in data.columns"
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
                <tr v-for="td in data.data" :key="td.id">
                    <td v-if="showIdColumn" class="p-2 text-justify border border-gray-300">
                        {{ td.id }}
                    </td>
                    <td
                        v-for="col in data.columns"
                        :key="col.name"
                        class="p-2 text-justify border border-gray-300"
                    >
                        <a
                            v-if="col.href"
                            class="
                                underline
                                text-blue-600
                                hover:text-blue-800
                                visited:text-purple-600
                            "
                            :href="td[col.href]"
                            >{{ td[col.name] }}</a
                        >
                        <span v-else>{{ td[col.name] }}</span>
                    </td>
                    <td v-if="showAction" class="p-2 text-center border border-gray-300 space-x-2">
                        <template v-for="act in td.action" :key="act.title">
                            <a
                                v-if="act.emit === undefined"
                                :class="act.className"
                                :title="act.title"
                                :href="act.href"
                                ><i :class="act.btnClassName"></i
                            ></a>
                            <a
                                v-else
                                :class="act.className"
                                :title="act.title"
                                href="#"
                                @click.prevent="
                                    (activeDelId = td.id),
                                        (activeDelMessage = act.modalMessage || 'Delete?'),
                                        (showDeleteModal = true)
                                "
                                ><i :class="act.btnClassName"></i
                            ></a>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>

        <Pagination v-if="showPagination" :data="data" @fetchData="$emit('fetchData', $event)" />

        <Modal
            v-if="showDeleteModal"
            @close="showDeleteModal = false"
            :message="activeDelMessage"
            @btn-click="$emit('itemDeleteConfirm', activeDelId), (showDeleteModal = false)"
        />
    </div>
</template>

<script>
import { computed, ref, toRefs } from 'vue';

import Modal from './Modal.vue';
import Pagination from './Pagination.vue';

export default {
    props: {
        data: { default: {} },
        showIdColumn: { type: Boolean, default: true },
        showAction: { type: Boolean, default: false },
    },
    components: {
        Modal,
        Pagination,
    },
    emits: ['fetchData', 'itemDeleteConfirm'],
    setup(props) {
        const { data } = toRefs(props);
        const showDeleteModal = ref(false);
        const activeDelId = ref(-1);
        const activeDelMessage = ref('');

        const showPagination = computed(
            () =>
                Object.prototype.hasOwnProperty.call(data.value, 'links') &&
                data.value.links.length > 3
        );

        return {
            activeDelId,
            activeDelMessage,
            showPagination,
            showDeleteModal,
        };
    },
};
</script>
