<template>
  <Default title="Stations" :showCreateBtn="isAdmin" :features="features" />
</template>

<script setup lang="ts">
  const { isAdmin } = useAuthStore()
  const features = [
    { name: 'name', title: 'Name' },
    // { name: 'address', title: 'Address' },
    { name: 'station_type', title: 'Type' },
    { name: 'status', title: 'Status', href: 'statusUrl' },
    { name: 'date_installed', title: 'Install Date' },
  ]
</script>
