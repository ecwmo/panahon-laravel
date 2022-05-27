<template>
  <Default
    title="Station Logs"
    :fetchUrl="fetchUrl"
    :baseUrl="baseUrl"
    :showCreateBtn="false"
    :showIdColumn="false"
    :features="features"
    :hasEditPage="false"
  >
  </Default>
</template>

<script setup lang="ts">
  const props = defineProps({
    fetchUrl: { type: String, required: true },
    baseUrl: { type: String, required: true },
    showCreateBtn: { type: Boolean, default: false },
  })
  const features = [
    { name: 'timestamp', title: 'Timestamp' },
    { name: 'message', title: 'Message' },
  ]
</script>
