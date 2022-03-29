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
            activeUrl === m.href ? 'fill-white' : 'fill-blue-300 group-hover:fill-white',
          ]"
        ></i>
        <span :class="activeUrl === m.href ? 'text-white' : 'text-blue-300 group-hover:text-white'">{{ m.label }}</span>
      </a>
    </div>
  </div>
</template>

<script lang="ts">
  import { defineComponent, toRefs, computed } from 'vue'
  export default defineComponent({
    props: {
      isPopup: { type: Boolean, default: false },
      isSuperAdmin: { type: Boolean, default: false },
      subUrl: { type: String, default: '/' },
    },
    setup(props) {
      const { isSuperAdmin, subUrl } = props
      const menu = [
        { href: `${subUrl}`, label: 'Dashboard', icon: 'tachometer-alt', display: true },
        { href: `${subUrl}stations`, label: 'Weather Stations', icon: 'umbrella', display: true },
        { href: `${subUrl}users`, label: 'User', icon: 'user', display: isSuperAdmin },
        { href: `${subUrl}roles`, label: 'Roles', icon: 'user-tag', display: isSuperAdmin },
      ]

      const activeUrl = computed(() => '/' + window.location.href.substring(window.location.href.lastIndexOf('/') + 1))

      return { menu, activeUrl }
    },
  })
</script>
