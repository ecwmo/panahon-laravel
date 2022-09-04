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

        <div
          class="w-full px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center"
          :class="[showDelete ? 'justify-between' : 'justify-end']"
        >
          <button
            v-if="showDelete"
            type="submit"
            class="text-sm uppercase font-semibold tracking-widest text-red-600 hover:underline"
            @click.prevent="handleDelete"
          >
            Delete
          </button>
          <BreezeButton v-if="showSubmitBtn" type="submit">
            {{ isUpdate ? 'Update' : 'Add' }}
          </BreezeButton>
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
