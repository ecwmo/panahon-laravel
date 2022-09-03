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
  const props = defineProps({ logs: { type: Object, default: () => ({}) } })
  const features = [
    { name: 'timestamp', title: 'Timestamp' },
    { name: 'message', title: 'Message' },
  ]
  const { logs } = toRefs(props)
  const data = { ...logs.value, features }
</script>
