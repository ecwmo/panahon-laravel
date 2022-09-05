<template layout="Auth">
  <Head title="Email Verification" />

  <h1 class="text-center font-bold text-3xl">Email Verification</h1>
  <div class="mx-auto my-6 w-24 border-b-2"></div>

  <div class="mb-4 text-sm text-gray-600">
    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just
    emailed to you? If you didn't receive the email, we will gladly send you another.
  </div>

  <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
    A new verification link has been sent to the email address you provided during registration.
  </div>

  <form @submit.prevent="submit">
    <div class="mt-4 flex items-center justify-between">
      <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Resend Verification Email
      </BreezeButton>

      <Link
        :href="route('logout')"
        method="post"
        as="button"
        class="underline text-sm text-gray-600 hover:text-gray-900"
        >Log Out</Link
      >
    </div>
  </form>
</template>

<script setup lang="ts">
  import { Head, Link } from '@inertiajs/inertia-vue3'

  const props = defineProps<{
    status: string
  }>()

  const form = useForm({})

  const submit = () => {
    form.post(route('verification.send'))
  }

  const verificationLinkSent = computed(() => props.status === 'verification-link-sent')
</script>
