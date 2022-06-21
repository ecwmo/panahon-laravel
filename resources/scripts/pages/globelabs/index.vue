<template>
  <Default title="Globe Labs" :showCreateBtn="false" :features="features" :hasEditPage="false" />
</template>

<script setup lang="ts">
  const features = [
    { name: 'mobile_number', title: 'Mobile Number' },
    { name: 'created_at', title: 'Subscription Date' },
    { name: 'station_id', title: 'Station', href: 'stationUrl' },
    { name: 'topup_date', title: 'Latest Topup' },
  ]
</script>
