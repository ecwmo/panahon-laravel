<template>
    <Default :fetchUrl="fetchUrl" :baseUrl="baseUrl" :isAdmin="isAdmin" :formatData="formatData">
        <template v-slot:header>Role <span class="font-bold">Details</span></template>
    </Default>
</template>

<script>
import { toRefs } from 'vue';

import Default from '../views/Default.vue';

export default {
    props: {
        fetchUrl: { type: String, required: true },
        baseUrl: { type: String, required: true },
        isAdmin: { type: Boolean, default: false },
    },
    components: { Default },
    setup(props) {
        const { baseUrl } = toRefs(props);

        const cols = [
            { name: 'name', title: 'Name' },
            { name: 'description', title: 'Description' },
        ];

        const formatData = (dat) => {
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
                        type: 'delete',
                        modalMessage: `delete '${d.name}' station?`,
                        btnClassName: 'fas fa-trash',
                    },
                ],
            }));

            return {
                ...dat,
                data: newDat,
                columns: cols,
            };
        };

        return { formatData };
    },
};
</script>
