<template layout>
  <Default title="SIM Card" basePath="simcard" :showCreateBtn="false" :data="data" :hasEditPage="false" />
</template>

<script setup lang="ts">
  const props = defineProps<{ subscribers: object }>()
  const features = [
    { name: 'mobile_number', title: 'Mobile Number' },
    { name: 'created_at', title: 'Subscription Date' },
    { name: 'station_name', title: 'Station', href: 'station_url' },
    { name: 'type', title: 'Type' },
    { name: 'topup_date', title: 'Latest Topup' },
  ]
  const data = { ...props.subscribers, features }
</script>
