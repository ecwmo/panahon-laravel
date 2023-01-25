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
        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
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
  import { RoleFields } from '@/types/form'
  import { isRequired } from 'intus/rules'

  const { isSuperAdmin } = useUser()

  const defaultData: RoleFields = {
    name: '',
    description: '',
  }

  const props = defineProps<{ role: RoleFields }>()

  const form = useValidatedForm(
    {
      ...defaultData,
      ...props.role,
    },
    {
      name: [isRequired()],
    }
  )
</script>
