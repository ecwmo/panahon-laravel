<template>
  <div class="flex items-center min-h-screen bg-white dark:bg-gray-900">
    <div class="container mx-auto">
      <div class="max-w-md mx-auto">
        <div class="text-center">
          <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">
            {{ user.id ? `Update ${user.name}` : 'Add new user' }}
          </h1>
        </div>

        <div
          v-show="success"
          class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-700 bg-green-100 border border-green-300"
        >
          <div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="100%"
              height="100%"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="feather feather-check-circle w-5 h-5 mx-2"
            >
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
          </div>
          <div class="text-xl font-normal max-w-full flex-initial">Updated successfully</div>
          <div class="flex flex-auto flex-row-reverse">
            <div @click="success = false">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="100%"
                height="100%"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2"
              >
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </div>
          </div>
        </div>

        <div class="m-7">
          <form @submit.prevent="handleFormSubmit">
            <div class="mb-3">
              <label for="name" class="form-label">User Name</label>
              <input
                type="text"
                class="form-control"
                placeholder="User Name"
                name="name"
                :value="user.name"
                @input="user.name = ($event.target as HTMLInputElement).value"
                required
              />
              <template v-if="errors">
                <span class="form-error" role="alert" v-for="(e, i) in errors.name" :key="i">
                  {{ e }}
                </span>
              </template>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                class="form-control"
                placeholder="Email"
                name="email"
                :value="user.email"
                @input="user.email = ($event.target as HTMLInputElement).value"
                required
              />
              <template v-if="errors">
                <span class="form-error" role="alert" v-for="(e, i) in errors.email" :key="i">
                  {{ e }}
                </span>
              </template>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                name="password"
                :value="user.password"
                @input="user.password = ($event.target as HTMLInputElement).value"
                :required="user.id === null"
              />
              <template v-if="errors">
                <span class="form-error" role="alert" v-for="(e, i) in errors.password" :key="i">
                  {{ e }}
                </span>
              </template>
            </div>

            <div class="mb-3" @mouseleave="showRoleDrpDwn = false">
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
                v-model="userRoleIds"
                v-show="showRoleDrpDwn"
                @blur="showRoleDrpDwn = false"
                multiple
              >
                <option v-for="role in roles" :key="role.id" :value="role.id">
                  {{ role.name }}
                </option>
              </select>
            </div>

            <div class="mb-3">
              <button type="submit" class="form-button">
                {{ user.id ? 'Update' : 'Add' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import { ref, toRefs, computed, onMounted, defineComponent } from 'vue'
  import axios from 'axios'

  import { Role } from '@/types/role'
  import { User, UserFormError } from '@/types/user'

  export default defineComponent({
    props: ['data', 'roles', 'baseUrl'],
    setup(props) {
      const { data, roles, baseUrl } = toRefs(props)
      const user = ref(<User>{
        name: '',
        roles: [],
      })
      const userRoleIds = ref([])
      const errors = ref(<UserFormError>{})
      const success = ref(false)
      const showRoleDrpDwn = ref(false)

      const userRoleNames = computed(() =>
        userRoleIds.value.map((id) => roles.value.filter((role: Role) => role['id'] === id)[0]['name'])
      )

      const handleFormSubmit = () => {
        success.value = false
        user.value.roles = userRoleIds.value
        if (user.value.id) {
          axios
            .patch(`${baseUrl.value}/${user.value.id}`, user.value)
            .then(() => (success.value = true))
            .catch(
              ({
                response: {
                  data: { errors: err },
                },
              }) => (errors.value = err)
            )
        } else {
          axios
            .post(baseUrl.value, user.value)
            .then(() => (success.value = true))
            .catch(
              ({
                response: {
                  data: { errors: err },
                },
              }) => (errors.value = err)
            )
        }
      }

      onMounted(() => {
        if (data.value.id) user.value = data.value
        if (data.value.roles) userRoleIds.value = data.value.roles.map(({ id }: { id: number }) => id)
      })

      return {
        user,
        userRoleIds,
        userRoleNames,
        success,
        errors,
        showRoleDrpDwn,
        handleFormSubmit,
      }
    },
  })
</script>

<style lang="sass" scoped>
  .form-label
      @apply block mb-2 text-sm text-gray-600
  .form-control
      @apply w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md
      &:focus
          @apply outline-none ring ring-blue-100 border-blue-300
  .form-button
      @apply w-full px-3 py-4 text-white bg-blue-500 rounded-md
      &:focus
          @apply bg-blue-600 outline-none
  .form-error
      @apply mb-3 text-xs text-red-500
</style>
