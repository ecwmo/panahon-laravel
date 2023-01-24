<template layout>
  <DataTable title="Stations" basePath="stations" :data="stations" />
</template>

<script setup lang="ts">
  defineProps<{
    stations: object
  }>()
</script>
