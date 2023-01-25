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
    <ConfirmDialogue ref="confirmDialogue" />
  </div>
</template>

<script setup lang="ts">
  import { FormFields } from '@/types/form'
  import { InertiaForm } from '@inertiajs/inertia-vue3'

  const props = withDefaults(
    defineProps<{
      title: string
      itemName: string
      propName: string
      form: InertiaForm<FormFields>
      showDelete: boolean
      showSubmitBtn: boolean
      isUpdate: boolean
    }>(),
    {
      title: '',
      itemName: '',
      propName: '',
      showDelete: false,
      showSubmitBtn: false,
      isUpdate: false,
    }
  )

  const confirmDialogue = ref()

  const { form, propName } = toRefs(props)

  const basePath = computed(() => route().current()?.split('.')[0])

  const handleFormSubmit = (actionType: string) => {
    const submitMethod = actionType === 'update' ? 'patch' : 'post'
    const submitUrl = actionType === 'update' ? `${form.value.id}` : route(`${basePath.value}.store`)
    form.value.submit(submitMethod, submitUrl, {
      onSuccess: (p) => {
        const { props: pProps } = p as { props: Record<string, FormFields> }
        form.value.id = pProps[propName.value].id
      },
    })
  }

  const handleDelete = async () => {
    const res = await confirmDialogue.value.show({
      title: `Delete ${propName.value}`,
      message: `Are you sure you want to delete this ${propName.value}?`,
      okButton: 'Delete',
    })

    if (res) {
      form.value.delete(`${form.value.id}`)
    }
  }
</script>
