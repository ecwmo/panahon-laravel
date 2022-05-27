<template>
  <Default title="Users" :baseUrl="baseUrl" :showCreateBtn="showCreateBtn" :features="features"> </Default>
</template>

<script setup lang="ts">
  const props = defineProps({
    baseUrl: { type: String, required: true },
    showCreateBtn: { type: Boolean, default: false },
  })
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'roleList', title: 'Roles' },
  ]
</script>
