<template>
  <form>
    <div class="px-10 py-12">
      <h1 class="text-center font-bold text-3xl">Register</h1>
      <div class="mx-auto mt-6 w-24 border-b-2"></div>

      <div class="mt-10">
        <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Name</label>
        <input
          id="name"
          type="text"
          class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
          placeholder="John Doe"
          name="name"
          v-model="user.name"
          required
          autofocus
        />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.name" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="mt-6">
        <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">E-Mail Address</label>
        <input
          id="email"
          type="email"
          class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
          placeholder="username@domain.com"
          name="email"
          v-model="user.email"
          required
        />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.email" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="mt-6">
        <label for="password" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Password</label>
        <input
          id="password"
          type="password"
          class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
          placeholder="************"
          name="password"
          v-model="user.password"
          required
        />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.password" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="mt-6">
        <label for="password-confirm" class="block mb-2 text-sm text-gray-600 dark:text-gray-400"
          >Confirm Password</label
        >
        <input
          id="password-confirm"
          type="password"
          class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
          placeholder="************"
          name="password_confirmation"
          v-model="user.password_confirmation"
          required
        />
      </div>
    </div>

    <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
      <button
        type="submit"
        class="flex items-center ml-auto px-7 py-3 font-semibold text-white bg-blue-500 rounded-md hover:bg-amber-400 focus:bg-amber-400 focus:outline-none"
        @click.prevent="handleRegister"
      >
        Register
      </button>
    </div>
  </form>
</template>

<script setup lang="ts">
  import { FormError } from '@/types/form'

  const user = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  })

  const errors = ref(<FormError>{})

  const authStore = useAuthStore()
  const route = useRoute()
  const router = useRouter()

  const handleRegister = async () => {
    const res = await authStore.register(user.value)
    if (res.status === 200) route?.query?.redirect ? router.push(<string>route?.query?.redirect) : router.go(-1)
    else {
      errors.value = res.data.errors
      user.value.password = ''
    }
  }
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

<route lang="yaml">
meta:
  layout: auth
</route>
