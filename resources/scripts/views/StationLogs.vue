<template>
  <Default :fetchUrl="fetchUrl" :baseUrl="baseUrl" :isAdmin="false" :showIdColumn="false" :features="features">
    <template v-slot:header>Station <span class="font-bold">Logs</span></template>
  </Default>
</template>

<script lang="ts">
  import { defineComponent } from 'vue'

  import Default from '../views/Default.vue'

  export default defineComponent({
    props: {
      fetchUrl: { type: String, required: true },
      baseUrl: { type: String, required: true },
      isAdmin: { type: Boolean, default: false },
    },
    components: { Default },
    setup() {
      const features = [
        { name: 'timestamp', title: 'Timestamp' },
        { name: 'message', title: 'Message' },
      ]

      return { features }
    },
  })
</script>
