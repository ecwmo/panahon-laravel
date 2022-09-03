<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <Link :href="route(`${basePath}.index`)" class="text-blue-400 hover:text-blue-600">{{ title }}</Link>
      <span class="text-blue-400 font-medium"> / </span>
      {{ isUpdate ? `${itemName}` : 'Create' }}
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="handleFormSubmit(isUpdate ? 'update' : 'create')">
        <slot></slot>

        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="showDelete" type="submit" class="text-red-600 hover:underline" @click.prevent="handleDelete">
            Delete
          </button>
          <button v-if="showSubmitBtn" type="submit" class="form-button">
            {{ isUpdate ? 'Update' : 'Add' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { Link } from '@inertiajs/inertia-vue3'

  const props = defineProps({
    title: { type: String, default: '' },
    basePath: { type: String, default: '' },
    itemName: { type: String, default: '' },
    formData: { type: Object, required: true },
    showDelete: { type: Boolean, default: false },
    showSubmitBtn: { type: Boolean, default: false },
    isUpdate: { type: Boolean, default: false },
  })

  const { formData, basePath } = toRefs(props)

  const handleFormSubmit = (actionType: string) => {
    if (actionType === 'update') {
      formData.value.patch(formData.value.id)
    } else {
      formData.value.post(route(`${basePath.value}.store`))
    }
  }

  const handleDelete = async () => {
    if (confirm('Are you sure you want to delete this station?')) {
      formData.value.delete(formData.value.id)
    }
  }
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
