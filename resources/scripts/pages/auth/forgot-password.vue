<template layout="auth">
  <div class="px-6 py-8">
    <Head title="Forgot Password" />

    <h1 class="text-center font-bold text-3xl">Forgot Password</h1>
    <div class="mx-auto my-6 w-24 border-b-2"></div>

    <div class="mb-4 text-sm text-gray-600">
      Forgot your password? No problem. Just let us know your email address and we will email you a password reset link
      that will allow you to choose a new one.
    </div>

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

      <div class="flex items-center justify-end mt-4">
        <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Email Password Reset Link
        </BreezeButton>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
  import { Head } from '@inertiajs/inertia-vue3'

  defineProps({
    status: String,
  })

  const form = useForm({
    email: '',
  })

  const submit = () => {
    form.post(route('password.email'))
  }
</script>
