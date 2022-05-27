<template>
  <div :class="isPopup ? 'text-sm' : 'hidden md:block bg-blue-700 flex-shrink-0 w-56 p-12 overflow-y-auto'">
    <div v-for="m in menu" :class="isPopup ? 'mb-2' : 'mb-4'">
      <router-link
        v-if="m.display"
        :to="m.href"
        class="flex items-center group"
        :class="isPopup ? 'py-1.5' : 'py-3'"
        @click.stop
      >
        <i
          :class="[
            `w-4 h-4 mr-2 fas fa-${m.icon} fa-fw`,
            m.active ? 'text-white' : 'text-blue-300 group-hover:text-white',
          ]"
        ></i>
        <span :class="m.active ? 'text-white' : 'text-blue-300 group-hover:text-white'">{{ m.label }}</span>
      </router-link>
    </div>
  </div>
</template>

<script setup lang="ts">
  const props = defineProps({
    isPopup: { type: Boolean, default: false },
  })

  const authStore = useAuthStore()

  const menu = ref([
    { href: '/', label: 'Dashboard', icon: 'tachometer-alt', display: true, active: false },
    { href: '/stations', label: 'Weather Stations', icon: 'umbrella', display: true, active: false },
    { href: '/users', label: 'User', icon: 'user', display: authStore.isSuperAdmin, active: false },
    { href: '/roles', label: 'Roles', icon: 'user-tag', display: authStore.isSuperAdmin, active: false },
  ])

  onMounted(() => {
    const activeIdx = menu.value.slice(1).findIndex((m) => window.location.pathname.indexOf(m.href) !== -1)
    if (activeIdx === -1) menu.value[0].active = true
    else menu.value[activeIdx + 1].active = true
  })
</script>
