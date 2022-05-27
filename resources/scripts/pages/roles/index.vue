<template>
  <Default title="Roles" :showCreateBtn="true" :features="features" />
</template>

<script setup lang="ts">
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'description', title: 'Description' },
  ]
</script>
