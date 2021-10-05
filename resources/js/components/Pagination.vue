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
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="100%"
                    height="100%"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-chevron-left w-6 h-6"
                >
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
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
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="100%"
                    height="100%"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-chevron-right w-6 h-6"
                >
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: ['data'],
};
</script>
