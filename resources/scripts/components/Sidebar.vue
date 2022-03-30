<template>
  <div :class="isPopup ? 'text-sm' : 'hidden md:block bg-blue-700 flex-shrink-0 w-56 p-12 overflow-y-auto'">
    <div v-for="m in menu" :class="isPopup ? 'mb-2' : 'mb-4'">
      <a
        v-if="m.display"
        :href="m.href"
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
      </a>
    </div>
  </div>
</template>

<script lang="ts">
  import { defineComponent, ref, toRefs, computed, onMounted } from 'vue'
  export default defineComponent({
    props: {
      isPopup: { type: Boolean, default: false },
      isSuperAdmin: { type: Boolean, default: false },
      subUrl: { type: String, default: '/' },
    },
    setup(props) {
      const { isSuperAdmin, subUrl } = toRefs(props)
      const menu = ref([
        { href: `${subUrl.value}`, label: 'Dashboard', icon: 'tachometer-alt', display: true, active: false },
        { href: `${subUrl.value}stations`, label: 'Weather Stations', icon: 'umbrella', display: true, active: false },
        { href: `${subUrl.value}users`, label: 'User', icon: 'user', display: isSuperAdmin.value, active: false },
        { href: `${subUrl.value}roles`, label: 'Roles', icon: 'user-tag', display: isSuperAdmin.value, active: false },
      ])

      onMounted(() => {
        const activeIdx = menu.value.slice(1).findIndex((m) => window.location.pathname.indexOf(m.href) !== -1)
        if (activeIdx === -1) menu.value[0].active = true
        else menu.value[activeIdx + 1].active = true
      })

      return { menu }
    },
  })
</script>
