<template layout>
  <DataTable title="Station Logs" basePath="stations/logs" :data="logs" />
</template>

<script setup lang="ts">
  defineProps<{ logs: object }>()
</script>
