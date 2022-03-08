<template>
  <a v-if="href !== '#'" :class="className" :title="title" :href="href"><i :class="btnClassName"></i></a>
  <a v-else :class="className" :title="title" href="#" @click.prevent="$emit('btnClicked')"
    ><i :class="btnClassName"></i
  ></a>
</template>

<script lang="ts">
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: {
      title: { type: String, required: true },
      className: { type: String, required: true },
      btnClassName: { type: String, required: true },
      href: { type: String, default: '#' },
    },
    emits: ['btnClicked'],
  })
</script>
