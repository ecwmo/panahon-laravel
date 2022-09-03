<template layout>
  <Default title="Globe Labs" basePath="glabs" :showCreateBtn="false" :data="data" :hasEditPage="false" />
</template>

<script setup lang="ts">
  const props = defineProps({ glabs: { type: Object, default: () => ({}) } })
  const features = [
    { name: 'mobile_number', title: 'Mobile Number' },
    { name: 'created_at', title: 'Subscription Date' },
    { name: 'station_name', title: 'Station', href: 'station_url' },
    { name: 'topup_date', title: 'Latest Topup' },
  ]
  const { glabs } = toRefs(props)
  const data = { ...glabs.value, features }
</script>
