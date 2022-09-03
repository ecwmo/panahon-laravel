<template layout>
  <Form
    title="Roles"
    basePath="roles"
    :itemName="form?.name"
    :formData="form"
    :showDelete="form?.id !== undefined && isSuperAdmin"
    :showSubmitBtn="isSuperAdmin"
    :isUpdate="form?.id !== undefined"
  >
    <div class="p-8 flex flex-wrap">
      <div class="mb-3 w-full">
        <label for="name" class="form-label">Role Name</label>
        <input type="text" class="form-control" placeholder="Role Name" name="name" v-model="form.name" required />
        <span v-if="form.errors.name" class="form-error" role="alert">
          {{ form.errors.name }}
        </span>
      </div>

      <div class="mb-3 w-full">
        <label for="description" class="form-label">Description</label>
        <input
          type="text"
          class="form-control"
          id="description"
          name="description"
          placeholder="Description"
          v-model="form.description"
        />
        <span v-if="form.errors.description" class="form-error" role="alert">
          {{ form.errors.description }}
        </span>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { PropType } from 'vue'
  import { RoleForm } from '@/scripts/types/form'

  const { isSuperAdmin } = useUser()

  const defaultData: RoleForm = {
    name: '',
    description: '',
  }

  const props = defineProps({
    role: {
      type: Object as PropType<RoleForm>,
      default: () => ({}),
    },
  })

  const { role: data } = toRefs(props)

  const form = useForm({
    ...defaultData,
    ...data.value,
  })
</script>

<style lang="sass" scoped>
  .form-label
      @apply block mb-2 text-sm text-gray-600
  .form-control
      @apply w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md
      &:focus
          @apply outline-none ring ring-blue-100 border-blue-300
  .form-error
      @apply mb-3 text-xs text-red-500
</style>
