<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <RouterLink :to="appRoute.basePath" class="text-blue-400 hover:text-blue-600">{{ title }}</RouterLink>
      <span class="text-blue-400 font-medium"> / </span>
      {{ isUpdate ? `${itemName}` : 'Create' }}
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form>
        <slot></slot>

        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="showDelete" type="submit" class="text-red-600 hover:underline" @click.prevent="$emit('delete')">
            Delete
          </button>
          <button
            v-if="showSubmitBtn"
            type="submit"
            class="form-button"
            @click.prevent="$emit('formSubmit', isUpdate ? 'update' : 'create')"
          >
            {{ isUpdate ? 'Update' : 'Add' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
  const props = defineProps({
    title: { type: String, default: '' },
    itemName: { type: String, default: '' },
    showDelete: { type: Boolean, default: false },
    showSubmitBtn: { type: Boolean, default: false },
    isUpdate: { type: Boolean, default: false },
  })

  const emit = defineEmits(['formSubmit', 'delete'])

  const appRoute = useAppRoute()
</script>

<style lang="sass" scoped>
  .form-label
      @apply block mb-2 text-sm text-gray-600
  .form-control
      @apply w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md
      &:focus
          @apply outline-none ring ring-blue-100 border-blue-300
  .form-button
      @apply px-5 py-3 flex items-center text-white bg-blue-500 rounded-md ml-auto
      &:focus
          @apply bg-blue-600 outline-none
  .form-error
      @apply mb-3 text-xs text-red-500
</style>
