<template>
  <Default title="Roles" :baseUrl="baseUrl" :showCreateBtn="showCreateBtn" :features="features"> </Default>
</template>

<script lang="ts">
  import { defineComponent } from 'vue'

  import Default from '@/views/Default.vue'

  export default defineComponent({
    props: {
      baseUrl: { type: String, required: true },
      showCreateBtn: { type: Boolean, default: false },
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
