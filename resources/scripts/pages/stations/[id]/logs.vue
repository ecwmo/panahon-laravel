<template>
  <Default
    title="Station Logs"
    :showCreateBtn="false"
    :showIdColumn="false"
    :features="features"
    :hasEditPage="false"
  />
</template>

<script setup lang="ts">
  const features = [
    { name: 'timestamp', title: 'Timestamp' },
    { name: 'message', title: 'Message' },
  ]
</script>
