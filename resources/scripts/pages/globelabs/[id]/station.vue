<template>
  <div>Redirecting...</div>
</template>

<script setup lang="ts">
  const route = useRoute()
  const router = useRouter()

  onMounted(() => {
    router.replace(`/stations/${route.params['id']}`)
  })
</script>
