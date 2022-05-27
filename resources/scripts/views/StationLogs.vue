<template>
  <Default
    title="Station Logs"
    :fetchUrl="fetchUrl"
    :baseUrl="baseUrl"
    :showCreateBtn="false"
    :showIdColumn="false"
    :features="features"
    :hasEditPage="false"
  >
  </Default>
</template>

<script lang="ts">
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: {
      fetchUrl: { type: String, required: true },
      baseUrl: { type: String, required: true },
      showCreateBtn: { type: Boolean, default: false },
    },
    setup() {
      const features = [
        { name: 'timestamp', title: 'Timestamp' },
        { name: 'message', title: 'Message' },
      ]

      return { features }
    },
  })
</script>
