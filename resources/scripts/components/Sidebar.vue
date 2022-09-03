<template>
  <div :class="isPopup ? 'text-sm' : 'hidden md:block bg-blue-700 flex-shrink-0 w-56 p-12 overflow-y-auto'">
    <div v-for="m in menu" :key="m.label" :class="isPopup ? 'mb-2' : 'mb-4'">
      <Link
        v-if="m.display"
        :href="m.href"
        class="flex items-center group"
        :class="[
          isPopup ? 'py-1.5' : 'py-3',
          $page.component.includes(m.name) ? 'text-white' : 'text-blue-300 group-hover:text-white',
        ]"
      >
        <i :class="`w-4 h-4 mr-2 fas fa-${m.icon} fa-fw`"></i>
        <span>{{ m.label }}</span>
      </Link>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { Link } from '@inertiajs/inertia-vue3'

  defineProps({
    isPopup: { type: Boolean, default: false },
  })

  const { isLoggedIn } = useUser()

  const menu = ref([
    { href: route('home'), name: 'index', label: 'Dashboard', icon: 'tachometer-alt', display: true },
    { href: route('stations.index'), name: 'station', label: 'Weather Stations', icon: 'umbrella', display: true },
    { href: route('glabs.index'), name: 'glab', label: 'Globe Labs', icon: 'signal', display: isLoggedIn },
    { href: route('users.index'), name: 'user', label: 'User', icon: 'user', display: isLoggedIn },
    { href: route('roles.index'), name: 'role', label: 'Roles', icon: 'user-tag', display: isLoggedIn },
  ])
</script>
