<template>
  <div
    v-show="showMenu || showSubmenu"
    class="fixed z-40 inset-0 bg-black opacity-20"
    @click=";[(showMenu = false), (showSubmenu = false)]"
  ></div>
  <div class="md:flex md:flex-shrink-0">
    <div class="bg-blue-900 md:flex-shrink-0 md:w-56 px-6 py-4 flex items-center justify-between md:justify-center">
      <a href="/" class="mt-1">
        <span class="font-semibold text-gray-200 text-lg md:text-2xl">{{ title }}</span>
      </a>
      <button @click.prevent="showMenu = true" class="md:hidden relative">
        <i class="text-white w-6 h-6 fas fa-bars"></i>
        <div v-show="showMenu" class="absolute z-50 top-0 right-0 mt-5">
          <div class="mt-2 px-8 py-4 shadow-lg bg-blue-800 rounded">
            <Sidebar :isPopup="true" :subUrl="subUrl" />
          </div>
        </div>
      </button>
    </div>
    <div class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-end items-center">
      <button v-if="authStore.isLoggedIn" type="button" class="mt-1 relative" @click.prevent="showSubmenu = true">
        <div class="flex items-center cursor-pointer select-none group">
          <div
            class="font-semibold text-gray-500 group-hover:text-blue-500 focus:text-blue-500 transition duration-300 mr-1 whitespace-nowrap"
          >
            <span>{{ authStore.user.name }}</span>
          </div>
          <i
            class="w-3 h-3 stroke-current group-hover:text-blue-500 text-gray-700 focus:text-blue-500 fas fa-chevron-down"
          ></i>
        </div>
        <div v-show="showSubmenu" class="absolute z-50 top-0 right-0 mt-5">
          <div class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
            <a href="#" class="block px-6 py-2 hover:bg-blue-500 hover:text-white" @click.prevent="logout">Logout</a>
          </div>
        </div>
      </button>
      <div v-else>
        <RouterLink class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300" to="/login">
          Login
        </RouterLink>
        <a class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300" :href="registerUrl"
          >Register</a
        >
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import axios from 'axios'

  const props = defineProps({
    title: { type: String, default: '' },
    logoutUrl: { type: String, default: '' },
    registerUrl: { type: String, default: '' },
    subUrl: { type: String, default: '' },
  })

  const showMenu = ref(false)
  const showSubmenu = ref(false)

  const { logoutUrl } = toRefs(props)
  const authStore = useAuthStore()

  const logout = async () => {
    const res = await axios.post(logoutUrl.value)
    if (res.status >= 200 && res.status < 300) {
      showSubmenu.value = false
    }
  }
</script>
