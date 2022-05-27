<template>
  <Form
    title="Roles"
    :itemName="role?.name"
    :showDelete="role?.id !== undefined"
    :isUpdate="role?.id !== undefined"
    @formSubmit="handleFormSubmit"
    @delete="handleDelete"
  >
    <div class="p-8 flex flex-wrap">
      <div class="mb-3 w-full">
        <label for="name" class="form-label">Role Name</label>
        <input type="text" class="form-control" placeholder="Role Name" name="name" v-model="role.name" required />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.name" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="mb-3 w-full">
        <label for="description" class="form-label">Description</label>
        <input
          type="text"
          class="form-control"
          id="description"
          name="description"
          placeholder="Description"
          v-model="role.description"
        />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.description" :key="i">
            {{ e }}
          </span>
        </template>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { Role, RoleFormError } from '@/types/role'

  const route = useRoute()
  const router = useRouter()
  const authStore = useAuthStore()
  const itemId = ref(-1)

  const role = ref(<Role>{
    name: '',
  })
  const errors = ref(<RoleFormError>{})

  const baseUrl = computed(() => `/${route.path.split('/')[1]}`)

  const fetchData = async () => {
    const { data } = await authStore.apiFetch(`/api${baseUrl.value}/${itemId.value}`)
    role.value = data
  }

  const handleFormSubmit = async (actionType: string) => {
    let res
    if (actionType === 'update') {
      res = await authStore
        .apiUpdate(`/api${baseUrl.value}/${itemId.value}`, role.value)
        .catch(({ response }) => response)
    } else {
      res = await authStore.apiCreate(`/api${baseUrl.value}`, role.value).catch(({ response }) => response)
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
    if (confirm('Are you sure you want to delete this station?')) {
      const res = await authStore.apiDelete(`/api${baseUrl.value}/${itemId.value}`)
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
