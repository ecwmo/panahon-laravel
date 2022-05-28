<template>
  <Default title="Users" :showCreateBtn="isSuperAdmin" :features="features" />
</template>

<script setup lang="ts">
  const { isSuperAdmin } = useAuthStore()
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'roleList', title: 'Roles' },
  ]
</script>
