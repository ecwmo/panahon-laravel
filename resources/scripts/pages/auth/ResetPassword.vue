<template>
  <AuthLayout>
    <Head title="Reset Password" />

    <h1 class="text-center font-bold text-3xl">Reset Password</h1>
    <div class="mx-auto my-6 w-24 border-b-2"></div>

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
          autocomplete="new-password"
        />
        <BreezeInputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <BreezeLabel for="password_confirmation" value="Confirm Password" />
        <BreezeInput
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password_confirmation"
          required
          autocomplete="new-password"
        />
        <BreezeInputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Reset Password
        </BreezeButton>
      </div>
    </form>
  </AuthLayout>
</template>

<script setup lang="ts">
  import { Head } from '@inertiajs/inertia-vue3'
  import AuthLayout from '@/layouts/Auth.vue'

  const props = defineProps<{
    email: string
    token: string
  }>()

  const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
  })

  const submit = () => {
    form.post(route('password.update'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
    })
  }
</script>
