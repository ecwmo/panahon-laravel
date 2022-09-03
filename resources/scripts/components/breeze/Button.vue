<template>
  <button
    :type="type"
    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-400 active:bg-amber-400 focus:outline-none focus:border-amber-600 focus:shadow-outline-gray transition ease-in-out duration-150"
  >
    <slot />
  </button>
</template>

<script setup lang="ts">
  import { ButtonHTMLAttributes, PropType } from 'vue'

  defineProps({
    type: {
      type: String as PropType<ButtonHTMLAttributes['type']>,
      default: () => 'submit',
    },
  })
</script>
