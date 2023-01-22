<template>
  <div :class="isPopup ? 'text-sm' : 'hidden md:block bg-blue-700 flex-shrink-0 w-56 p-12 overflow-y-auto'">
    <div v-for="m in menu" :key="m.label" :class="isPopup ? 'mb-2' : 'mb-4'">
      <InertiaLink
        v-if="m.display"
        :href="m.href"
        class="flex items-center group"
        :class="[
          isPopup ? 'py-1.5' : 'py-3',
          $page.component.toLowerCase().includes(m.name) ? 'text-white' : 'text-blue-300 group-hover:text-white',
        ]"
      >
        <div class="text-base mr-2">
          <i-fa6-solid-gauge-high v-if="m.icon === 'gauge-high'" />
          <i-fa6-solid-umbrella v-else-if="m.icon === 'umbrella'" />
          <i-material-symbols-signal-cellular-alt v-else-if="m.icon === 'signal'" />
          <i-material-symbols-person v-else-if="m.icon === 'person'" />
          <i-material-symbols-lock-person v-else-if="m.icon === 'lock-person'" />
        </div>
        <span>{{ m.label }}</span>
      </InertiaLink>
    </div>
  </div>
</template>

<script setup lang="ts">
  defineProps({
    isPopup: { type: Boolean, default: false },
  })

  const { isLoggedIn } = useUser()

  const menu = ref([
    { href: route('home'), name: 'index', label: 'Dashboard', icon: 'gauge-high', display: true },
    { href: route('stations.index'), name: 'station', label: 'Weather Stations', icon: 'umbrella', display: true },
    { href: route('simcard.index'), name: 'simcard', label: 'SIM Card', icon: 'signal', display: isLoggedIn },
    { href: route('users.index'), name: 'user', label: 'User', icon: 'person', display: isLoggedIn },
    { href: route('roles.index'), name: 'role', label: 'Roles', icon: 'lock-person', display: isLoggedIn },
  ])
</script>
