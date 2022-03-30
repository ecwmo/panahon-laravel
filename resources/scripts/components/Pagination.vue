<template>
  <div class="flex flex-wrap -mb-1">
    <!-- Previous Page Link -->
    <div
      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
      :class="
        data.prev_page_url !== null
          ? 'cursor-pointer hover:bg-white focus:border-blue-500 focus:text-blue-500'
          : 'text-gray-400'
      "
      @click="$emit('pageChange', data.prev_page_url)"
    >
      « Previous
    </div>

    <!-- Pagination Elements -->
    <template v-for="link in data.links" :key="link.label">
      <div v-if="link.label === '...'" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded text-gray-400">
        {{ link.label }}
      </div>
      <div
        v-else-if="!isNaN(+link.label)"
        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
        :class="link.active ? 'bg-white' : 'cursor-pointer hover:bg-white focus:border-blue-500 focus:text-blue-500'"
        @click="$emit('pageChange', link.url)"
      >
        {{ link.label }}
      </div>
    </template>

    <!-- Next Page Link -->
    <div
      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
      :class="
        data.next_page_url !== null
          ? 'cursor-pointer hover:bg-white focus:border-blue-500 focus:text-blue-500'
          : 'text-gray-400'
      "
      @click="$emit('pageChange', data.next_page_url)"
    >
      Next »
    </div>
  </div>
</template>

<script lang="ts">
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: ['data'],
    emits: ['pageChange'],
  })
</script>
