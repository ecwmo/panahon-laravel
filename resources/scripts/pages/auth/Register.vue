<template layout="Auth">
  <InertiaHead title="Register" />

  <h1 class="text-center font-bold text-3xl">Register</h1>
  <div class="mx-auto mt-6 w-24 border-b-2"></div>

  <form @submit.prevent="submit">
    <div>
      <BreezeLabel for="name" value="Name" />
      <BreezeInput
        id="name"
        type="text"
        class="mt-1 block w-full"
        v-model="form.name"
        required
        autofocus
        autocomplete="name"
      />
      <BreezeInputError class="mt-2" :message="form.errors.name" />
    </div>

    <div class="mt-4">
      <BreezeLabel for="email" value="Email" />
      <BreezeInput
        id="email"
        type="email"
        class="mt-1 block w-full"
        v-model="form.email"
        required
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
      <InertiaLink :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
        Already registered?
      </InertiaLink>

      <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Register
      </BreezeButton>
    </div>
  </form>
</template>

<script setup lang="ts">
  const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
  })

  const submit = () => {
    form.post(route('register'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
    })
  }
</script>
