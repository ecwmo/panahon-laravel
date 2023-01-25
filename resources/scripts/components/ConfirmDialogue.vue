<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" class="relative z-50">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                {{ title }}
              </DialogTitle>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  {{ message }}
                </p>
              </div>

              <div class="mt-4">
                <div class="flex space-x-2">
                  <button
                    type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    @click="handleCancel"
                  >
                    {{ cancelButton }}
                  </button>
                  <button
                    type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-red-100 px-4 py-2 text-sm font-medium text-red-900 hover:bg-red-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                    @click="handleConfirm"
                  >
                    {{ okButton }}
                  </button>
                </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup lang="ts">
  const isOpen = ref(false)
  const resolvePromise = ref()
  const rejectPromise = ref()

  const title = ref('')
  const message = ref('')
  const cancelButton = ref('Cancel')
  const okButton = ref('Ok')

  const show = (opts: { title?: string; message?: string; okButton?: string; cancelButton?: string }) => {
    title.value = opts?.title ?? ''
    message.value = opts?.message ?? ''
    okButton.value = opts?.okButton ?? 'Ok'
    cancelButton.value = opts?.cancelButton ?? 'Cancel'

    isOpen.value = true

    return new Promise((resolve, reject) => {
      resolvePromise.value = resolve
      rejectPromise.value = reject
    })
  }

  defineExpose({ show })

  const handleCancel = () => {
    isOpen.value = false
    resolvePromise.value(false)
  }

  const handleConfirm = () => {
    isOpen.value = false
    resolvePromise.value(true)
  }
</script>
