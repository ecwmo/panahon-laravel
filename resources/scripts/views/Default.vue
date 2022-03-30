<template>
  <div>
    <div class="mb-6 flex justify-between items-center">
      <h1 class="font-bold text-3xl">{{ title }}</h1>
      <a
        v-if="showCreateBtn"
        :href="`${baseUrl}/create`"
        class="rounded px-3 py-2 m-1 shadow bg-blue-600 border-blue-700 hover:bg-amber-400"
      >
        <i class="text-white fas fa-plus"></i>
      </a>
    </div>

    <DataTable :data="tableData" :showIdColumn="showIdColumn" @fetchData="fetchData"> </DataTable>
  </div>
</template>

<script lang="ts">
  import { ref, toRefs, onMounted, defineComponent, PropType } from 'vue'
  import axios from 'axios'

  import DataTable from '@/components/DataTable.vue'

  interface Datum {
    [k: string]: any
  }

  interface Feature {
    name: string
    title: string
    href?: string
  }

  export default defineComponent({
    props: {
      title: { type: String, default: '' },
      fetchUrl: { type: String, required: true },
      features: { type: Object as PropType<Feature[]>, required: true },
      baseUrl: { type: String, required: true },
      showCreateBtn: { type: Boolean, default: false },
      showIdColumn: { type: Boolean, default: true },
      hasEditPage: { type: Boolean, default: true },
    },
    components: { DataTable },
    setup(props) {
      const tableData = ref({})

      const { fetchUrl, baseUrl, features, hasEditPage } = toRefs(props)

      const fetchData = async (url: string) => {
        if (url) {
          const featHrefs = features.value.filter(({ href }) => href !== undefined).map(({ href }) => href)
          const dat = await axios.get(url).then(({ data: d }) => d)
          const newDat = dat.data.map((d: Datum) => ({
            ...d,
            statusUrl: featHrefs.includes('statusUrl') ? `${baseUrl.value}/${d.id}/logs` : undefined,
            editUrl: hasEditPage.value ? `${baseUrl.value}/${d.id}/edit` : undefined,
          }))

          tableData.value = {
            ...dat,
            data: newDat,
            features: features.value,
          }
        }
      }

      onMounted(() => fetchData(fetchUrl.value))

      return {
        tableData,
        fetchData,
      }
    },
  })
</script>
