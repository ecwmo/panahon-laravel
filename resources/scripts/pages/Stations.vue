<template>
  <DefaultLayout>
    <Default title="Stations" basePath="stations" :showCreateBtn="isAdmin" :data="data" />
  </DefaultLayout>
</template>

<script setup lang="ts">
  import DefaultLayout from '@/layouts/Default.vue'

  const props = defineProps<{
    stations: object
  }>()
  const features = [
    { name: 'name', title: 'Name' },
    // { name: 'address', title: 'Address' },
    { name: 'station_type', title: 'Type' },
    { name: 'status', title: 'Status', href: 'status_url' },
    { name: 'date_installed', title: 'Install Date' },
  ]
  const data = { ...props.stations, features }
  const { isAdmin } = useUser()
</script>
