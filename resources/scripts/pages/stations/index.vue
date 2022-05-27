<template>
  <Default title="Stations" :showCreateBtn="true" :features="features" />
</template>

<script setup lang="ts">
  const features = [
    { name: 'name', title: 'Name' },
    // { name: 'address', title: 'Address' },
    { name: 'station_type', title: 'Type' },
    { name: 'status', title: 'Status', href: 'statusUrl' },
    { name: 'date_installed', title: 'Install Date' },
  ]
</script>
