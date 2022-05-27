<template>
  <Default title="Stations" :baseUrl="baseUrl" :showCreateBtn="showCreateBtn" :features="features"> </Default>
</template>

<script setup lang="ts">
  const props = defineProps({
    baseUrl: { type: String, required: true },
    showCreateBtn: { type: Boolean, default: false },
  })

  const features = [
    { name: 'name', title: 'Name' },
    // { name: 'address', title: 'Address' },
    { name: 'station_type', title: 'Type' },
    { name: 'status', title: 'Status', href: 'statusUrl' },
    { name: 'date_installed', title: 'Install Date' },
  ]
</script>
