<template>
  <DefaultLayout>
    <Default title="Roles" basePath="roles" :showCreateBtn="isSuperAdmin" :data="data" />
  </DefaultLayout>
</template>

<script setup lang="ts">
  import DefaultLayout from '@/layouts/Default.vue'

  const props = defineProps<{ roles: object }>()
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'description', title: 'Description' },
  ]
  const data = { ...props.roles, features }
  const { isSuperAdmin } = useUser()
</script>
