<template>
  <DefaultLayout>
    <Default
      title="Station Logs"
      basePath="stations"
      :showCreateBtn="false"
      :showIdColumn="false"
      :data="data"
      :hasEditPage="false"
    />
  </DefaultLayout>
</template>

<script setup lang="ts">
  import DefaultLayout from '@/layouts/Default.vue'

  const props = defineProps<{ logs: object }>()
  const features = [
    { name: 'timestamp', title: 'Timestamp' },
    { name: 'message', title: 'Message' },
  ]
  const data = { ...props.logs, features }
</script>
