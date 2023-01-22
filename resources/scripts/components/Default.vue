<template>
  <div>
    <div class="mb-6 flex justify-between items-center">
      <h1 class="font-bold text-3xl">{{ title }}</h1>
      <InertiaLink
        v-if="showCreateBtn"
        :href="route(`${basePath}.create`)"
        class="rounded px-3 py-2 m-1 shadow bg-blue-600 border-blue-700 hover:bg-amber-400"
        as="button"
      >
        <i-mdi-plus class="text-white text-lg" />
      </InertiaLink>
    </div>

    <DataTable :basePath="basePath" :data="data" :show-id-column="showIdColumn" :hasEditPage="hasEditPage" />
  </div>
</template>

<script setup lang="ts">
  defineProps({
    title: { type: String, default: '' },
    basePath: { type: String, default: '' },
    data: { type: Object, required: true },
    showCreateBtn: { type: Boolean, default: false },
    showIdColumn: { type: Boolean, default: true },
    hasEditPage: { type: Boolean, default: true },
  })
</script>
