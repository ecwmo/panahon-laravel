<template layout>
  <Form
    title="Users"
    propName="user"
    :itemName="form?.name ?? ''"
    :form="form"
    :showDelete="form?.id !== undefined && isSuperAdmin"
    :showSubmitBtn="isSuperAdmin"
    :isUpdate="form?.id !== undefined"
  >
    <div class="p-8 flex flex-wrap">
      <div class="w-full">
        <BreezeLabel for="name" value="Name" />
        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
        <BreezeInputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4 w-full">
        <BreezeLabel for="email" value="Email" />
        <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
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
  import { RoleFields, SelectOption, UserFields } from '@/types/form'
  import { isEmail, isRequired } from 'intus/rules'

  const { isSuperAdmin } = useUser()

  const defaultData: UserFields = {
    name: '',
    email: '',
    password: '',
    roleIds: [1],
  }

  const props = defineProps<{ user: UserFields; roles: RoleFields[] }>()

  const form = useValidatedForm(
    {
      ...defaultData,
      ...props.user,
    },
    {
      name: [isRequired()],
      email: [isRequired(), isEmail()],
    }
  )

  const mSelecData = computed(() =>
    props.roles.map((role: RoleFields): SelectOption => ({ name: role.name, value: role.id }))
  )
</script>
