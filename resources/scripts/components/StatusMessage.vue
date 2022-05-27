<template>
  <div v-show="message.show" class="mb-8 flex items-center justify-between bg-green-500 rounded max-w-3xl">
    <div class="flex items-center">
      <i class="ml-4 mr-2 flex-shrink-0 w-4 h-4 text-white fas fa-check"></i>
      <div class="py-4 text-white text-sm font-medium">{{ message.text }}</div>
    </div>
    <button type="button" class="group mr-2 p-2" @click.prevent="message.show = false">
      <i class="block w-4 h-4 text-green-800 group-hover:text-white fas fa-times"></i>
    </button>
  </div>
</template>

<script setup lang="ts">
  import { PropType } from 'vue'

  type Message = {
    text: string
    show: boolean
    type?: string
  }

  const props = defineProps({
    message: { type: Object as PropType<Message>, required: true },
  })
</script>
