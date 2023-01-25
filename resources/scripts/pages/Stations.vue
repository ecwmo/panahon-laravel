<template layout>
  <DataTable title="Stations" :data="stations" />
</template>

<script setup lang="ts">
  defineProps<{
    stations: object
  }>()
</script>
