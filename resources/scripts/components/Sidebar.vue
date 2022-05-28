<template>
  <div :class="isPopup ? 'text-sm' : 'hidden md:block bg-blue-700 flex-shrink-0 w-56 p-12 overflow-y-auto'">
    <div v-for="m in menu" :class="isPopup ? 'mb-2' : 'mb-4'">
      <router-link
        v-if="m.display"
        :to="m.href"
        class="flex items-center group"
        :class="isPopup ? 'py-1.5' : 'py-3'"
        :exact="m.exact"
      >
        <i :class="`w-4 h-4 mr-2 fas fa-${m.icon} fa-fw`"></i>
        <span>{{ m.label }}</span>
      </router-link>
    </div>
  </div>
</template>

<script setup lang="ts">
  const props = defineProps({
    isPopup: { type: Boolean, default: false },
  })

  const { isLoggedIn } = useAuthStore()

  const menu = ref([
    { href: '/', label: 'Dashboard', icon: 'tachometer-alt', display: true, exact: true },
    { href: '/stations', label: 'Weather Stations', icon: 'umbrella', display: true, exact: false },
    { href: '/users', label: 'User', icon: 'user', display: isLoggedIn, exact: false },
    { href: '/roles', label: 'Roles', icon: 'user-tag', display: isLoggedIn, exact: false },
  ])
</script>

<style lang="sass" scoped>
  a
    svg
      @apply text-blue-300 group-hover:text-white
    span
      @apply text-blue-300 group-hover:text-white
  a.router-link-active, a.router-link-exact-active
      svg
        @apply text-white
      span
        @apply text-white
</style>
