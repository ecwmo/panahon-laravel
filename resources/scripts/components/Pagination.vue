<template>
  <div class="flex flex-wrap -mb-1">
    <!-- Previous Page InertiaLink -->
    <InertiaLink
      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
      :class="
        data.prev_page_url !== null
          ? 'hover:bg-white focus:border-blue-500 focus:text-blue-500'
          : 'cursor-not-allowed text-gray-400'
      "
      :href="data.prev_page_url"
    >
      « Previous
    </InertiaLink>

    <!-- Pagination Elements -->
    <template v-for="link in data.links" :key="link.label">
      <div v-if="link.label === '...'" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded text-gray-400">
        {{ link.label }}
      </div>
      <InertiaLink
        v-else-if="!isNaN(+link.label)"
        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
        :class="
          link.active ? 'cursor-not-allowed bg-white' : 'hover:bg-white focus:border-blue-500 focus:text-blue-500'
        "
        :href="link.url"
      >
        {{ link.label }}
      </InertiaLink>
    </template>

    <!-- Next Page InertiaLink -->
    <InertiaLink
      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
      :class="
        data.next_page_url !== null
          ? 'hover:bg-white focus:border-blue-500 focus:text-blue-500'
          : 'cursor-not-allowed text-gray-400'
      "
      :href="data.next_page_url"
    >
      Next »
    </InertiaLink>
  </div>
</template>

<script setup lang="ts">
  defineProps({ data: { type: Object, required: true } })
</script>
