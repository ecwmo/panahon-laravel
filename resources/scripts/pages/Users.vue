<template layout>
  <DataTable title="Users" basePath="users" :data="users" />
</template>

<script setup lang="ts">
  defineProps<{
    users: object
  }>()
</script>
