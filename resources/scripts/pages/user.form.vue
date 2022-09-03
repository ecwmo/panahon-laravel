<template layout>
  <Form
    title="Users"
    basePath="users"
    :itemName="form?.name"
    :formData="form"
    :showDelete="form?.id !== undefined && isSuperAdmin"
    :showSubmitBtn="isSuperAdmin"
    :isUpdate="form?.id !== undefined"
  >
    <div class="p-8 flex flex-wrap">
      <div class="mb-3 w-full">
        <label for="name" class="form-label">User Name</label>
        <input type="text" class="form-control" placeholder="User Name" name="name" v-model="form.name" required />
        <span v-if="form.errors.name" class="form-error" role="alert">
          {{ form.errors.name }}
        </span>
      </div>

      <div class="mb-3 w-full">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Email" name="email" v-model="form.email" required />
        <span v-if="form.errors.email" class="form-error" role="alert">
          {{ form.errors.email }}
        </span>
      </div>

      <div class="mb-3 w-full">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          placeholder="Password"
          name="password"
          v-model="form.password"
          :required="form.id === null"
        />
        <span v-if="form.errors.password" class="form-error" role="alert">
          {{ form.errors.password }}
        </span>
      </div>

      <div class="mb-3 w-full" @mouseleave="showRoleDrpDwn = false">
        <label for="roles" class="form-label">Roles</label>
        <div class="w-full flex">
          <input
            type="text"
            class="form-control"
            placeholder="Roles"
            id="roles"
            @focus="showRoleDrpDwn = true"
            :value="userRoleNames"
            readonly
          />
          <button
            class="px-3 py-2 border bg-blue-300 border-blue-400 rounded-r-md"
            type="button"
            id="roleDrpDwnBtn"
            @click="showRoleDrpDwn = !showRoleDrpDwn"
          >
            <i class="fas" :class="showRoleDrpDwn ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
          </button>
        </div>
        <select
          class="form-control"
          v-model="form.roleIds"
          v-show="showRoleDrpDwn"
          @blur="showRoleDrpDwn = false"
          multiple
        >
          <option v-for="role in roles" :key="role.id" :value="role.id">
            {{ role?.name }}
          </option>
        </select>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { PropType } from 'vue'
  import { UserForm, RoleForm } from '@/scripts/types/form'

  const { isSuperAdmin } = useUser()

  const defaultData: UserForm = {
    name: '',
    email: '',
    password: '',
    roleIds: [1],
  }

  const props = defineProps({
    user: {
      type: Object as PropType<UserForm>,
      default: () => ({}),
    },
    roles: {
      type: Object as PropType<RoleForm[]>,
      default: () => ({}),
    },
  })

  const { user: data, roles } = toRefs(props)

  const form = useForm({
    ...defaultData,
    ...data.value,
  })

  const showRoleDrpDwn = ref(false)

  const userRoleNames = computed(() =>
    form.roleIds?.map((id: number) => roles.value?.filter((role: RoleForm) => role['id'] === id)[0]['name'])
  )
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
