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
  import { ref, toRefs, onMounted, defineComponent } from 'vue'
  import axios from 'axios'

  import DataTable from '@/components/DataTable.vue'

  interface PageLink {
    label: string
    url: string
  }

  interface TableDatum {
    current_page: string
    links: PageLink[]
    data: string[]
  }

  interface Datum {
    [k: string]: any
  }

  export default defineComponent({
    props: {
      title: { type: String, default: '' },
      fetchUrl: { type: String, required: true },
      features: { type: Object, required: true },
      baseUrl: { type: String, required: true },
      showCreateBtn: { type: Boolean, default: false },
      showIdColumn: { type: Boolean, default: true },
      hasEditPage: { type: Boolean, default: true },
    },
    components: { DataTable },
    setup(props) {
      const tableData = ref({} as TableDatum)

      const { fetchUrl, baseUrl, features, hasEditPage } = toRefs(props)

      const fetchData = async (url: string) => {
        if (url) {
          const dat = await axios.get(url).then(({ data: d }) => d)
          const newDat = dat.data.map((d: Datum) => ({
            ...d,
            statusUrl: `${baseUrl.value}/${d.id}/logs`,
            editUrl: hasEditPage.value ? `${baseUrl.value}/${d.id}/edit` : undefined,
          }))

          tableData.value = {
            ...dat,
            data: newDat,
            columns: features.value,
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
