<template layout>
  <Default title="Users" basePath="users" :showCreateBtn="isSuperAdmin" :data="data" />
</template>

<script setup lang="ts">
  const props = defineProps<{
    users: object
  }>()
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'roleList', title: 'Roles' },
  ]
  const data = { ...props.users, features }
  const { isSuperAdmin } = useUser()
</script>
