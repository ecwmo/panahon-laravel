<template>
  <nav class="flex flex-wrap justify-between md:justify-end items-center bg-white shadow-lg px-2 md:px-6 py-2">
    <div class="block md:hidden flex items-center flex-no-shrink mr-6">
      <!-- <img src="@/assets/logo.png" alt="Logo" class="h-8 w-8 md:h-10 md:w-10 mr-2" /> -->
      <span class="font-semibold text-gray-900 text-lg md:text-2xl">{{ title }}</span>
    </div>
    <div class="flex md:hidden">
      <button
        @click.prevent="open = !open"
        class="flex items-center px-3 py-2 border rounded hover:text-white hover:border-white hover:bg-black"
      >
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <div :class="[open ? 'relative w-full' : 'hidden']" class="md:flex">
      <div
        class="flex flex-col flex-grow items-center md:flex md:flex-row"
        :class="{ 'absolute right-0 bg-white shadow-lg': open }"
      >
        <slot></slot>
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
  import { ref, defineComponent } from 'vue'
  export default defineComponent({
    props: ['title'],
    setup() {
      const open = ref(false)

      return {
        open,
      }
    },
  })
</script>
