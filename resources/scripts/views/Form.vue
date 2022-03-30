<template>
  <div>
    <StatusMessage :message="message"></StatusMessage>

    <div>
      <h1 class="mb-8 font-bold text-3xl">
        <a :href="baseUrl" class="text-blue-400 hover:text-blue-600">{{ title }}</a>
        <span class="text-blue-400 font-medium"> / </span>
        {{ data.id ? `${data.name}` : 'Create' }}
      </h1>
      <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
        <form>
          <slot></slot>

          <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
            <button v-if="data.id" type="submit" class="text-red-600 hover:underline" @click.prevent="handleDelete">
              Delete
            </button>
            <button type="submit" class="form-button" @click.prevent="handleFormSubmit">
              {{ data.id ? 'Update' : 'Add' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import { ref, toRefs, computed, onMounted, defineComponent } from 'vue'
  import axios from 'axios'

  import StatusMessage from '@/components/StatusMessage.vue'

  export default defineComponent({
    props: ['title', 'data', 'baseUrl'],
    emit: ['formError'],
    components: { StatusMessage },
    setup(props, { emit }) {
      const { data, baseUrl } = toRefs(props)
      const message = ref({ type: 'delete', text: '', show: false })

      const handleDelete = async () => {
        if (confirm('Are you sure you want to delete this station?')) {
          message.value = { type: 'delete', text: '', show: false }
          const res = await axios.delete(`${baseUrl.value}/${data.value.id}`)
          if (res.status === 200) {
            message.value = { ...message.value, text: 'Deleted successfully', show: true }
            window.location.assign(baseUrl.value)
          }
        }
      }

      const handleFormSubmit = async () => {
        let res
        message.value = { type: 'update', text: '', show: false }
        if (data.value.id) {
          res = await axios.patch(`${baseUrl.value}/${data.value.id}`, data.value).catch(({ response }) => response)
          message.value.text = 'Updated successfully'
        } else {
          res = await axios.post(baseUrl.value, data.value).catch(({ response }) => response)
        }
        if (res.status === 200) {
          message.value = { ...message.value, show: true }
        } else if (res.status === 201) {
          window.location.assign(<any>`${baseUrl.value}/${res.data.id}/edit?r=c`)
        } else emit('formError', res?.data?.errors)
      }

      onMounted(() => {
        const urlParams = new URLSearchParams(window.location.search)
        if (urlParams.get('r') === 'c') {
          message.value = { type: 'create', text: 'Added successfully', show: true }
          window.location.search = ''
        }
      })

      return {
        message,
        handleFormSubmit,
        handleDelete,
      }
    },
  })
</script>

<style lang="sass" scoped>
  .form-label
      @apply block mb-2 text-sm text-gray-600
  .form-control
      @apply w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md
      &:focus
          @apply outline-none ring ring-blue-100 border-blue-300
  .form-button
      @apply px-5 py-3 flex items-center text-white bg-blue-500 rounded-md ml-auto
      &:focus
          @apply bg-blue-600 outline-none
  .form-error
      @apply mb-3 text-xs text-red-500
</style>
