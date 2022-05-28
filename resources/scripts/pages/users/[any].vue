<template>
  <Form
    title="Users"
    :itemName="user?.name"
    :showDelete="user?.id !== undefined"
    :isUpdate="user?.id !== undefined"
    @formSubmit="handleFormSubmit"
    @delete="handleDelete"
  >
    <div class="p-8 flex flex-wrap">
      <div class="mb-3 w-full">
        <label for="name" class="form-label">User Name</label>
        <input type="text" class="form-control" placeholder="User Name" name="name" v-model="user.name" required />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.name" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="mb-3 w-full">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Email" name="email" v-model="user.email" required />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.email" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="mb-3 w-full">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          placeholder="Password"
          name="password"
          v-model="user.password"
          :required="user.id === null"
        />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.password" :key="i">
            {{ e }}
          </span>
        </template>
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
          v-model="user.roles"
          v-show="showRoleDrpDwn"
          @blur="showRoleDrpDwn = false"
          multiple
        >
          <option v-for="role in roles" :key="role.id" :value="role.id">
            {{ role.name }}
          </option>
        </select>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { Role } from '@/types/role'
  import { User, UserFormError } from '@/types/user'

  const route = useRoute()
  const apiRoute = useApiRoute()
  const router = useRouter()
  const itemId = ref(-1)

  const user = ref(<User>{
    name: '',
    roles: [],
  })
  const roles = ref()
  const errors = ref(<UserFormError>{})
  const showRoleDrpDwn = ref(false)

  const baseUrl = computed(() => `/${route.path.split('/')[1]}`)

  const userRoleNames = computed(() =>
    user.value.roles.map((id) => roles.value.filter((role: Role) => role['id'] === id)[0]['name'])
  )

  const fetchData = async () => {
    const { data } = await apiRoute.apiShow()
    user.value = data.user
    user.value.roles = data?.userRoleIds
    roles.value = data.roles
  }

  const fetchRoles = async () => {
    const { data } = await apiRoute.apiFetch({ url: `/api/roles?all` })
    roles.value = data
  }

  const handleFormSubmit = async (actionType: string) => {
    let res
    if (actionType === 'update') {
      res = await apiRoute.apiUpdate(user.value).catch(({ response }) => response)
    } else {
      res = await apiRoute.apiCreate(user.value).catch(({ response }) => response)
    }
    if (res.status === 200) {
      router.push(`${baseUrl.value}/${itemId.value}`)
    } else if (res.status === 201) {
      router.push(`${baseUrl.value}/${res.data.id}`)
    } else {
      errors.value = res.data.errors
    }
  }

  const handleDelete = async () => {
    if (confirm('Are you sure you want to delete this user?')) {
      const res = await apiRoute.apiDelete()
      if (res.status === 200) {
        router.push(baseUrl.value)
      }
    }
  }

  onMounted(() => {
    const param = <string>route.params['any']
    itemId.value = isNaN(+param) ? -1 : +param
    if (itemId.value >= 0) {
      fetchData()
    } else {
      fetchRoles()
    }
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
