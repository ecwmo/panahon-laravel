<template layout="Auth">
  <Head title="Confirm Password" />

  <h1 class="text-center font-bold text-3xl">Confirm Password</h1>
  <div class="mx-auto my-6 w-24 border-b-2"></div>

  <div class="mb-4 text-sm text-gray-600">
    This is a secure area of the application. Please confirm your password before continuing.
  </div>

  <form @submit.prevent="submit">
    <div>
      <BreezeLabel for="password" value="Password" />
      <BreezeInput
        id="password"
        type="password"
        class="mt-1 block w-full"
        v-model="form.password"
        required
        autocomplete="current-password"
        autofocus
      />
      <BreezeInputError class="mt-2" :message="form.errors.password" />
    </div>

    <div class="flex justify-end mt-4">
      <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Confirm
      </BreezeButton>
    </div>
  </form>
</template>

<script setup lang="ts">
  import { Head } from '@inertiajs/inertia-vue3'

  const form = useForm({
    password: '',
  })

  const submit = () => {
    form.post(route('password.confirm'), {
      onFinish: () => form.reset(),
    })
  }
</script>
