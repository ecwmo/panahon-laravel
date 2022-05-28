<template>
  <div>
    <StatusMessage :message="message"></StatusMessage>

    <div class="mb-6 flex justify-between items-center">
      <h1 class="font-bold text-3xl">{{ title }}</h1>
      <router-link
        v-if="showCreateBtn"
        :to="`${appRoute.basePath}/create`"
        class="rounded px-3 py-2 m-1 shadow bg-blue-600 border-blue-700 hover:bg-amber-400"
      >
        <i class="text-white fas fa-plus"></i>
      </router-link>
    </div>

    <DataTable :data="tableData" :showIdColumn="showIdColumn" @pageChange="fetchData" />
  </div>
</template>

<script setup lang="ts">
  import { PropType } from 'vue'

  interface Datum {
    [k: string]: any
  }

  interface Feature {
    name: string
    title: string
    href?: string
  }

  const props = defineProps({
    title: { type: String, default: '' },
    features: { type: Object as PropType<Feature[]>, required: true },
    showCreateBtn: { type: Boolean, default: false },
    showIdColumn: { type: Boolean, default: true },
    hasEditPage: { type: Boolean, default: true },
  })

  const tableData = ref({})
  const message = ref({ type: 'delete', text: '', show: false })

  const appRoute = useAppRoute()

  const { features, hasEditPage } = toRefs(props)

  const fetchData = async (page = 1) => {
    const featHrefs = features.value.filter(({ href }) => href !== undefined).map(({ href }) => href)
    const { data: dat } = await appRoute.apiFetch({ page: page })
    const newDat = dat.data.map((d: Datum) => ({
      ...d,
      statusUrl: featHrefs.includes('statusUrl') ? `${appRoute.basePath}/${d.id}/logs` : undefined,
      editUrl: hasEditPage.value ? `${appRoute.basePath}/${d.id}` : undefined,
    }))

    tableData.value = {
      ...dat,
      data: newDat,
      features: features.value,
    }
  }

  onMounted(async () => {
    await fetchData()
  })
</script>
