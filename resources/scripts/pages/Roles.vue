<template layout>
  <Default title="Roles" basePath="roles" :showCreateBtn="isSuperAdmin" :data="data" />
</template>

<script setup lang="ts">
  const props = defineProps<{ roles: object }>()
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'description', title: 'Description' },
  ]
  const data = { ...props.roles, features }
  const { isSuperAdmin } = useUser()
</script>
