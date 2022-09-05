<template layout>
  <Default
    title="Station Logs"
    basePath="stations"
    :showCreateBtn="false"
    :showIdColumn="false"
    :data="data"
    :hasEditPage="false"
  />
</template>

<script setup lang="ts">
  const props = defineProps<{ logs: object }>()
  const features = [
    { name: 'timestamp', title: 'Timestamp' },
    { name: 'message', title: 'Message' },
  ]
  const data = { ...props.logs, features }
</script>
