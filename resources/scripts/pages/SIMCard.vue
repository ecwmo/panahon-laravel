<template layout>
  <DataTable title="SIM Card" basePath="simcard" :data="subscribers" />
</template>

<script setup lang="ts">
  defineProps<{ subscribers: object }>()
</script>
