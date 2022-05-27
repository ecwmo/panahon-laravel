<template>
  <div class="h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50">
    <div class="relative flex flex-col p-8 bg-white shadow-md hover:shadow-lg rounded-2xl">
      <div class="absolute top-1 right-2.5 cursor-pointer" @click.prevent="$emit('close')">
        <i class="fas fa-times"></i>
      </div>
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <div class="border rounded-2xl p-3 border border-blue-100 text-blue-400 bg-blue-50">
            <div class="flex justify-center items-center border-4 border-blue-400 rounded-full w-8 h-8">
              <i class="fas fa-info stroke-current"></i>
            </div>
          </div>
          <div class="flex flex-col ml-3">
            <slot></slot>
          </div>
        </div>
        <a
          class="flex-no-shrink bg-red-500 px-5 ml-4 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full"
          role="button"
          href="#"
          @click.prevent="$emit('btnClick')"
        >
          {{ btnLabel }}
        </a>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  const props = defineProps({
    btnLabel: { default: 'Delete' },
  })

  const emit = defineEmits(['btnClick', 'close'])
</script>
