<template>
  <input
    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    :value="modelValue"
    @input="handleInput"
    ref="input"
  />
</template>

<script setup lang="ts">
  defineProps(['modelValue'])

  const emit = defineEmits(['update:modelValue'])

  const input = ref()

  const handleInput = (e: Event) => {
    emit('update:modelValue', (e.target as HTMLInputElement).value)
  }

  onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
      input.value?.focus()
    }
  })
</script>
