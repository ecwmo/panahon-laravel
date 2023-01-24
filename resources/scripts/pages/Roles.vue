<template layout>
  <DataTable title="Roles" basePath="roles" :data="roles" />
</template>

<script setup lang="ts">
  defineProps<{ roles: object }>()
</script>
