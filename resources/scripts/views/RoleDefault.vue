<template>
  <Default :fetchUrl="fetchUrl" :baseUrl="baseUrl" :isAdmin="isAdmin" :features="features">
    <template v-slot:header>Role <span class="font-bold">Details</span></template>
  </Default>
</template>

<script lang="ts">
  import { defineComponent } from 'vue'

  import Default from '@/views/Default.vue'

  export default defineComponent({
    props: {
      fetchUrl: { type: String, required: true },
      baseUrl: { type: String, required: true },
      isAdmin: { type: Boolean, default: false },
    },
    components: { Default },
    setup() {
      const features = [
        { name: 'name', title: 'Name' },
        { name: 'description', title: 'Description' },
      ]

      return { features }
    },
  })
</script>
