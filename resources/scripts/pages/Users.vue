<template>
  <DefaultLayout>
    <Default title="Users" basePath="users" :showCreateBtn="isSuperAdmin" :data="data" />
  </DefaultLayout>
</template>

<script setup lang="ts">
  import DefaultLayout from '@/layouts/Default.vue'

  const props = defineProps<{
    users: object
  }>()
  const features = [
    { name: 'name', title: 'Name' },
    { name: 'roleList', title: 'Roles' },
  ]
  const data = { ...props.users, features }
  const { isSuperAdmin } = useUser()
</script>
