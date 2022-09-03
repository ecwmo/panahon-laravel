<template>
  <AuthLayout>
    <Head title="Log in" />

    <h1 class="text-center font-bold text-3xl">Login</h1>
    <div class="mx-auto my-6 w-24 border-b-2"></div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <BreezeLabel for="email" value="Email" />
        <BreezeInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autofocus
          autocomplete="username"
        />
        <BreezeInputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <BreezeLabel for="password" value="Password" />
        <BreezeInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="current-password"
        />
        <BreezeInputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="block mt-4">
        <label class="flex items-center">
          <BreezeCheckbox name="remember" v-model:checked="form.remember" />
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Forgot your password?
        </Link>

        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Log in
        </BreezeButton>
      </div>
    </form>
  </AuthLayout>
</template>

<script setup lang="ts">
  import { Head, Link } from '@inertiajs/inertia-vue3'
  import AuthLayout from '@/layouts/Auth.vue'

  defineProps<{
    canResetPassword: boolean
    status?: string
  }>()

  const form = useForm({
    email: null,
    password: null,
    remember: false,
  })

  const submit = () => {
    form.post(route('login'), {
      onFinish: () => form.reset('password'),
    })
  }
</script>
