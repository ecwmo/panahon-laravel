<template>
  <TransitionGroup
    tag="div"
    enter-from-class="translate-x-full opacity-0"
    enter-active-class="duration-500"
    leave-active-class="duration-500"
    leave-to-class="translate-x-full opacity-0"
    class="space-y-4 w-full max-w-xs"
  >
    <ToastListItem
      v-for="(item, idx) in toastStore.items"
      :key="item.key"
      :message="item.message"
      @remove="toastStore.remove(idx)"
    />
  </TransitionGroup>
</template>

<script setup lang="ts">
  import { Inertia } from '@inertiajs/inertia'

  const toastStore = useToastStore()
  const page = usePage()

  const removeFinishEventListener = Inertia.on('finish', () => {
    if (page.props.value.toast) {
      toastStore.add({
        message: page.props.value.toast as string,
      })
    }
  })

  onUnmounted(() => removeFinishEventListener())
</script>
