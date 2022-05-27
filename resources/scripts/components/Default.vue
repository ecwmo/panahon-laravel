<template>
  <div>
    <StatusMessage :message="message"></StatusMessage>

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

    <DataTable :data="tableData" :showIdColumn="showIdColumn" @pageChange="fetchData"> </DataTable>
  </div>
</template>

<script lang="ts">
  import { ref, toRefs, onMounted, defineComponent, PropType } from 'vue'
  import axios from 'axios'

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
      fetchUrl: { type: String, default: '' },
      features: { type: Object as PropType<Feature[]>, required: true },
      baseUrl: { type: String, required: true },
      showCreateBtn: { type: Boolean, default: false },
      showIdColumn: { type: Boolean, default: true },
      hasEditPage: { type: Boolean, default: true },
    },
    setup(props) {
      const tableData = ref({})
      const message = ref({ type: 'delete', text: '', show: false })

      const { fetchUrl, baseUrl, features, hasEditPage } = toRefs(props)

      const fetchData = async (page = 1) => {
        const url = new URL(fetchUrl.value === '' ? `${baseUrl.value}?view=0` : fetchUrl.value)
        url.searchParams.append('page', `${page}`)

        const featHrefs = features.value.filter(({ href }) => href !== undefined).map(({ href }) => href)
        const dat = await axios.get(url.toString()).then(({ data: d }) => d)
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

      onMounted(async () => {
        const redirectType = localStorage.getItem('redirect')
        if (redirectType === 'delete') {
          message.value = { type: 'delete', text: 'Deleted successfully', show: true }
        }
        localStorage.removeItem('redirect')

        await fetchData()
      })

      return {
        message,
        tableData,
        fetchData,
      }
    },
  })
</script>
