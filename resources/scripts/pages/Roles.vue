<template layout>
  <DataTable title="Roles" :data="roles" />
</template>

<script setup lang="ts">
  defineProps<{ roles: object }>()
</script>
