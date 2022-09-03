<template>
  <DefaultLayout>
    <Default title="Globe Labs" basePath="glabs" :showCreateBtn="false" :data="data" :hasEditPage="false" />
  </DefaultLayout>
</template>

<script setup lang="ts">
  import DefaultLayout from '@/layouts/Default.vue'

  const props = defineProps<{ glabs: object }>()
  const features = [
    { name: 'mobile_number', title: 'Mobile Number' },
    { name: 'created_at', title: 'Subscription Date' },
    { name: 'station_name', title: 'Station', href: 'station_url' },
    { name: 'topup_date', title: 'Latest Topup' },
  ]
  const data = { ...props.glabs, features }
</script>
