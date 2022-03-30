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
          <a
            v-if="f.href"
            tabindex="-1"
            class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600"
            :href="td[f.href]"
            >{{ td[f.name] }}</a
          >
          <a v-else-if="td.editUrl" tabindex="-1" class="px-4 flex items-center" :href="td.editUrl">{{ td[f.name] }}</a>
          <span v-else>{{ td[f.name] }}</span>
        </td>
        <td v-if="td.editUrl" class="p-3 text-justify border-t w-px">
          <a :href="td.editUrl" tabindex="-1" class="px-4 flex items-center">
            <i class="block w-4 h-4 text-gray-400 fas fa-chevron-right"></i>
          </a>
        </td>
      </tr>
    </table>
  </div>
  <div class="mt-6">
    <Pagination v-if="showPagination" :data="data" @pageChange="$emit('fetchData', $event)" />
  </div>
</template>

<script lang="ts">
  import { computed, ref, toRefs, defineComponent } from 'vue'

  import ActionBtn from '@/components/ActionBtn.vue'
  import Pagination from '@/components/Pagination.vue'

  export default defineComponent({
    props: {
      data: { type: Object, required: true },
      showIdColumn: { type: Boolean, default: true },
    },
    components: {
      ActionBtn,
      Pagination,
    },
    emits: ['fetchData'],
    setup(props) {
      const { data } = toRefs(props)

      const showPagination = computed(
        () => Object.prototype.hasOwnProperty.call(data.value, 'links') && data.value.links.length > 3
      )

      return {
        showPagination,
      }
    },
  })
</script>
