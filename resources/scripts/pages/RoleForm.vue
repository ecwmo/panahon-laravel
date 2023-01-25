<template layout>
  <Form
    title="Roles"
    propName="role"
    :itemName="form?.name ?? ''"
    :formData="form"
    :showDelete="form?.id !== undefined && isSuperAdmin"
    :showSubmitBtn="isSuperAdmin"
    :isUpdate="form?.id !== undefined"
  >
    <div class="p-8 flex flex-wrap">
      <div class="w-full">
        <BreezeLabel for="name" value="Role Name" />
        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
        <BreezeInputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4 w-full">
        <BreezeLabel for="description" value="Description" />
        <BreezeInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" />
        <BreezeInputError class="mt-2" :message="form.errors.description" />
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { RoleForm } from '@/types/form'

  const { isSuperAdmin } = useUser()

  const defaultData: RoleForm = {
    name: '',
    description: '',
  }

  const props = defineProps<{ role: RoleForm }>()

  const form = useForm({
    ...defaultData,
    ...props.role,
  })
</script>
