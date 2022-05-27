<template>
  <Default title="Users" :showCreateBtn="true" :features="features" />
</template>

<script setup lang="ts">
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'roleList', title: 'Roles' },
  ]
</script>
