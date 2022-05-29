<template>
  <form>
    <div class="px-10 py-12">
      <h1 class="text-center font-bold text-3xl">Login</h1>
      <div class="mx-auto mt-6 w-24 border-b-2"></div>

      <div class="mt-10">
        <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">E-Mail Address</label>
        <input
          id="email"
          type="email"
          class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('email') is-invalid @enderror"
          name="email"
          placeholder="username@domain.com"
          required
          autofocus
          v-model="user.email"
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
          class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('password') is-invalid @enderror"
          name="password"
          placeholder="************"
          required
          v-model="user.password"
        />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.password" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="mt-6">
        <label class="inline-flex items-center">
          <input
            type="checkbox"
            class="form-checkbox h-5 w-5 text-gray-600"
            name="remember_me"
            id="remember_me"
            v-model="user.remember_me"
          />
          <span class="ml-2 text-gray-700"> Remember Me </span>
        </label>
      </div>
    </div>

    <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
      <button
        type="submit"
        class="flex items-center ml-auto px-7 py-3 font-semibold text-white bg-blue-500 rounded-md hover:bg-amber-400 focus:bg-amber-400 focus:outline-none"
        @click.prevent="handleLogin"
      >
        Login
      </button>
    </div>
  </form>
</template>

<script setup lang="ts">
  import { FormError } from '@/types/form'

  const user = ref({
    email: '',
    password: '',
    remember_me: false,
  })

  const errors = ref(<FormError>{})

  const authStore = useAuthStore()
  const route = useRoute()
  const router = useRouter()

  const handleLogin = async () => {
    const res = await authStore.login(user.value)
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
