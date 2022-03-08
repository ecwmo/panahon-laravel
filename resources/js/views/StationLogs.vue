<template>
    <Default
        :fetchUrl="fetchUrl"
        :baseUrl="baseUrl"
        :isAdmin="false"
        :showIdColumn="false"
        :formatData="formatData"
    >
        <template v-slot:header>Station <span class="font-bold">Logs</span></template>
    </Default>
</template>

<script>
import Default from '../views/Default.vue';

export default {
    props: {
        fetchUrl: { type: String, required: true },
        baseUrl: { type: String, required: true },
        isAdmin: { type: Boolean, default: false },
    },
    components: { Default },
    setup() {
        const cols = [
            { name: 'timestamp', title: 'Timestamp' },
            { name: 'message', title: 'Message' },
        ];

        const formatData = (dat) => ({
            ...dat,
            columns: cols,
        });

        return { formatData };
    },
};
</script>
