<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <InertiaLink :href="route(`${basePath}.index`)" class="text-blue-400 hover:text-blue-600">{{
        title
      }}</InertiaLink>
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
  import { RoleForm, StationForm, UserForm } from '@/types/form'

  const props = withDefaults(
    defineProps<{
      title: string
      basePath: string
      itemName: string
      propName: string
      formData: ReturnType<typeof useForm<StationForm | UserForm | RoleForm>>
      showDelete: boolean
      showSubmitBtn: boolean
      isUpdate: boolean
    }>(),
    {
      title: '',
      basePath: '',
      itemName: '',
      propName: '',
      showDelete: false,
      showSubmitBtn: false,
      isUpdate: false,
    }
  )

  const { formData, basePath, propName } = toRefs(props)

  const handleFormSubmit = (actionType: string) => {
    if (actionType === 'update') {
      formData.value.patch(`${formData.value.id}`)
    } else {
      formData.value.post(route(`${basePath.value}.store`), {
        onSuccess: (p) => {
          const { props: pProps } = p as { props: { [key: string]: StationForm | UserForm | RoleForm } }
          formData.value.id = pProps[propName.value].id
        },
      })
    }
  }

  const handleDelete = async () => {
    if (confirm(`Are you sure you want to delete this ${propName}?`)) {
      formData.value.delete(`${formData.value.id}`)
    }
  }
</script>
