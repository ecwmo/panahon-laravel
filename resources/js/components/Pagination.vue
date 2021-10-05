<template>
    <nav class="flex">
        <ul class="flex h-8 font-medium rounded-full bg-gray-200">
            <!-- Previous Page Link -->
            <li
                class="h-8 w-8 mr-1 flex justify-center items-center rounded-full bg-gray-200"
                :class="{ 'cursor-pointer': data.prev_page_url !== null }"
                :aria-disabled="data.prev_page_url === null"
                @click="$emit('fetchData', data.prev_page_url)"
            >
                &lt;
            </li>

            <!-- Pagination Elements -->
            <template v-for="link in data.links" :key="link.label">
                <li
                    v-if="link.label === '...'"
                    class="w-8 md:flex justify-center items-center hidden leading-5 rounded-full"
                    aria-disabled="true"
                >
                    {{ link.label }}
                </li>
                <li
                    v-else-if="!isNaN(+link.label)"
                    class="w-8 md:flex justify-center items-center hidden leading-5 rounded-full"
                    :class="[link.active ? 'bg-blue-600 text-white' : 'cursor-pointer']"
                    :aria-disabled="link.url === null"
                    @click="$emit('fetchData', link.url)"
                >
                    {{ link.label }}
                </li>
            </template>

            <!-- Next Page Link -->
            <li
                class="h-8 w-8 ml-1 flex justify-center items-center rounded-full bg-gray-200"
                :class="{ 'cursor-pointer': data.next_page_url !== null }"
                :aria-disabled="data.next_page_url === null"
                @click="$emit('fetchData', data.next_page_url)"
            >
                &gt;
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: ['data'],
};
</script>
