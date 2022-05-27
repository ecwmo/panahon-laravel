<template>
  <Form title="Roles" :data="role" :baseUrl="baseUrl" @formError="handleError">
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

  const props = defineProps({
    data: { type: Object, required: true },
    baseUrl: { type: String, default: '' },
  })

  const { data } = toRefs(props)
  const role = ref(<Role>{
    name: '',
  })
  const errors = ref(<RoleFormError>{})

  const handleError = (e: RoleFormError) => (errors.value = e)

  onMounted(() => {
    if (data.value.id) role.value = <Role>data.value
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
