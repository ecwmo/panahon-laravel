<template>
  <Default title="Roles" :baseUrl="baseUrl" :showCreateBtn="showCreateBtn" :features="features"> </Default>
</template>

<script setup lang="ts">
  const props = defineProps({
    baseUrl: { type: String, required: true },
    showCreateBtn: { type: Boolean, default: false },
  })

  const features = [
    { name: 'name', title: 'Name' },
    { name: 'description', title: 'Description' },
  ]
</script>
