<template>
  <Default title="Users" :baseUrl="baseUrl" :showCreateBtn="showCreateBtn" :features="features"> </Default>
</template>

<script lang="ts">
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: {
      baseUrl: { type: String, required: true },
      showCreateBtn: { type: Boolean, default: false },
    },
    setup() {
      const features = [
        { name: 'name', title: 'Name' },
        { name: 'roleList', title: 'Roles' },
      ]

      return { features }
    },
  })
</script>
