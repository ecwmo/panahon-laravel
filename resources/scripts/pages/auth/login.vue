<template>
  <form>
    <div class="px-10 py-12">
      <h1 class="text-center font-bold text-3xl">Login</h1>
      <div class="mx-auto mt-6 w-24 border-b-2"></div>

      <div v-show="hasError" class="w-full flex justify-center">
        <span class="mt-3 text-xs text-red-500" role="alert"> incorrect email or password </span>
      </div>

      <div :class="hasError ? 'mt-7' : 'mt-10'">
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
          @focus="hasError = false"
        />
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
          @focus="hasError = false"
        />
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
  const user = ref({
    email: '',
    password: '',
  })

  const hasError = ref(false)

  const authStore = useAuthStore()
  const route = useRoute()
  const router = useRouter()

  const handleLogin = async () => {
    hasError.value = false
    await authStore.login(user.value).catch((r) => r)
    if (authStore.isLoggedIn) route?.query?.redirect ? router.push(<string>route?.query?.redirect) : router.go(-1)
    else {
      hasError.value = true
      user.value.password = ''
    }
  }
</script>

<route lang="yaml">
meta:
  layout: auth
</route>
