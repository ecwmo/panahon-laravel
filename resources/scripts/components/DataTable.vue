<template>
  <div class="bg-white rounded-md shadow overflow-x-auto">
    <table class="w-full whitespace-nowrap">
      <tr class="text-left font-bold">
        <th v-if="showIdColumn" class="p-3" scope="col">#</th>
        <th v-for="f in data.features" :key="f.name" class="p-2" scope="col">
          {{ f.title }}
        </th>
      </tr>
      <tr v-for="td in data.data" :key="td.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td v-if="showIdColumn" class="p-3 text-justify border-t">
          {{ td.id }}
        </td>
        <td v-for="f in data.features" :key="f.name" class="p-2 text-justify border-t">
          <Link
            v-if="f.href"
            tabindex="-1"
            class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600"
            :href="td[f.href]"
          >
            {{ getValue(f.name, td) }}
          </Link>
          <Link
            v-else-if="hasEditPage"
            tabindex="-1"
            class="px-4 flex items-center"
            :href="route(`${basePath}.update`, td.id)"
          >
            {{ getValue(f.name, td) }}
          </Link>
          <span v-else>{{ getValue(f.name, td) }}</span>
        </td>
        <td v-if="hasEditPage" class="p-3 text-justify border-t w-px">
          <Link :href="route(`${basePath}.update`, td.id)" tabindex="-1" class="px-4 flex items-center">
            <i class="block w-4 h-4 text-gray-400 fas fa-chevron-right"></i>
          </Link>
        </td>
      </tr>
    </table>
  </div>
  <div class="mt-6">
    <Pagination v-if="showPagination" :data="data" />
  </div>
</template>

<script setup lang="ts">
  import { Link } from '@inertiajs/inertia-vue3'
  import { isValid, format } from 'date-fns'

  const props = defineProps({
    basePath: { type: String, default: '' },
    data: { type: Object, required: true },
    showIdColumn: { type: Boolean, default: true },
    hasEditPage: { type: Boolean, default: true },
  })

  const { data } = toRefs(props)

  const getValue = (s: string, obj: { [id: string]: any }) => {
    const dateAttrs = ['created_at', 'date_installed', 'topup_date']

    if (dateAttrs.includes(s)) {
      const dt = new Date(obj[s])
      if (isValid(dt)) {
        return format(dt, 'yyyy-MM-dd')
      }
      return
    }
    return obj[s]
  }

  const showPagination = computed(
    () => Object.prototype.hasOwnProperty.call(data.value, 'links') && data.value.links.length > 3
  )
</script>
