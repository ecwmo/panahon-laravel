<template layout>
  <Form
    title="Users"
    propName="user"
    :itemName="form?.name ?? ''"
    :formData="form"
    :showDelete="form?.id !== undefined && isSuperAdmin"
    :showSubmitBtn="isSuperAdmin"
    :isUpdate="form?.id !== undefined"
  >
    <div class="p-8 flex flex-wrap">
      <div class="w-full">
        <BreezeLabel for="name" value="Name" />
        <BreezeInput
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.name"
          required
          autofocus
          autocomplete="name"
        />
        <BreezeInputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4 w-full">
        <BreezeLabel for="email" value="Email" />
        <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
        <BreezeInputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4 w-full">
        <BreezeLabel for="password" value="Password" />
        <BreezeInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          :required="form.id === null"
        />
        <BreezeInputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4 w-full">
        <BreezeLabel for="roles" value="Roles" />
        <MultiSelectInput v-model="form.roleIds" :data="mSelecData"></MultiSelectInput>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { RoleForm, SelectOption, UserForm } from '@/types/form'

  const { isSuperAdmin } = useUser()

  const defaultData: UserForm = {
    name: '',
    email: '',
    password: '',
    roleIds: [1],
  }

  const props = defineProps<{ user?: UserForm; roles: RoleForm[] }>()

  const form = useForm({
    ...defaultData,
    ...props.user,
  })

  const mSelecData = computed(() =>
    props.roles.map((role: RoleForm): SelectOption => ({ name: role.name, value: role.id }))
  )
</script>
