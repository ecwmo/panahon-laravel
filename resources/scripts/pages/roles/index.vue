<template>
  <Default title="Roles" :showCreateBtn="isSuperAdmin" :features="features" />
</template>

<script setup lang="ts">
  const { isSuperAdmin } = useAuthStore()
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'description', title: 'Description' },
  ]
</script>
