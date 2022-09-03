<template layout>
  <Default title="Users" basePath="users" :showCreateBtn="isSuperAdmin" :data="data" />
</template>

<script setup lang="ts">
  const props = defineProps({ users: { type: Object, default: () => ({}) } })
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'roleList', title: 'Roles' },
  ]
  const { users } = toRefs(props)
  const data = { ...users.value, features }
  const { isSuperAdmin } = useUser()
</script>
