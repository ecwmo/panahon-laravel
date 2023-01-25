<template layout>
  <DataTable title="SIM Card" :data="subscribers" />
</template>

<script setup lang="ts">
  defineProps<{ subscribers: object }>()
</script>
