<template layout>
  <DataTable title="Users" :data="users" />
</template>

<script setup lang="ts">
  defineProps<{
    users: object
  }>()
</script>
