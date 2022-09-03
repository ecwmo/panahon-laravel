<template layout>
  <Default title="Stations" basePath="stations" :showCreateBtn="isAdmin" :data="data" />
</template>

<script setup lang="ts">
  const props = defineProps({ stations: { type: Object, default: () => ({}) } })
  const features = [
    { name: 'name', title: 'Name' },
    // { name: 'address', title: 'Address' },
    { name: 'station_type', title: 'Type' },
    { name: 'status', title: 'Status', href: 'status_url' },
    { name: 'date_installed', title: 'Install Date' },
  ]
  const { stations } = toRefs(props)
  const data = { ...stations.value, features }

  const { isAdmin } = useUser()
</script>
