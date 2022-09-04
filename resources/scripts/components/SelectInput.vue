<template>
  <select
    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    :value="modelValue"
    @change="handelChange"
  >
    <slot />
  </select>
</template>

<script setup lang="ts">
  defineProps(['modelValue'])

  const emit = defineEmits(['update:modelValue'])

  const handelChange = (e: Event) => {
    emit('update:modelValue', (e.target as HTMLSelectElement).value)
  }
</script>
