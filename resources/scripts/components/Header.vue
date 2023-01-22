<template>
  <div
    v-show="showMenu || showSubmenu"
    class="fixed z-40 inset-0 bg-black opacity-20"
    @click=";[(showMenu = false), (showSubmenu = false)]"
  ></div>
  <div class="md:flex md:flex-shrink-0">
    <div
      class="bg-blue-900 md:flex-shrink-0 md:w-56 px-4 md:px-6 py-2 md:py-4 flex items-center justify-between md:justify-center"
    >
      <a :href="route('home')" class="mt-1">
        <span class="font-semibold text-gray-200 text-lg md:text-2xl">{{ title }}</span>
      </a>
      <button class="md:hidden relative" @click.prevent="showMenu = true">
        <i-fa6-solid-bars class="text-white text-xl" />
        <div v-show="showMenu" class="absolute z-50 top-0 right-0 mt-5">
          <div class="mt-2 px-8 py-4 shadow-lg bg-blue-800 rounded">
            <Sidebar :is-popup="true" />
          </div>
        </div>
      </button>
    </div>
    <div class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-end items-center">
      <div v-if="isLoggedIn">
        <InertiaLink
          class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300"
          :href="route('logout')"
          method="post"
          as="button"
        >
          Logout
        </InertiaLink>
      </div>
      <div v-else>
        <InertiaLink
          class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300"
          :href="route('login')"
        >
          Login
        </InertiaLink>
        <InertiaLink
          class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300"
          :href="route('register')"
        >
          Register
        </InertiaLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  defineProps({
    title: { type: String, default: '' },
  })

  const { isLoggedIn } = useUser()

  const showMenu = ref(false)
  const showSubmenu = ref(false)
</script>
