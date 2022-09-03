<template layout>
  <Default title="Roles" basePath="roles" :showCreateBtn="isSuperAdmin" :data="data" />
</template>

<script setup lang="ts">
  const props = defineProps({ roles: { type: Object, default: () => ({}) } })
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'description', title: 'Description' },
  ]
  const { roles } = toRefs(props)
  const data = { ...roles.value, features }
  const { isSuperAdmin } = useUser()
</script>
