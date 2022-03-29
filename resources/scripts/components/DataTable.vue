<template>
  <div class="bg-white rounded-md shadow overflow-x-auto">
    <table class="w-full whitespace-nowrap">
      <tr class="text-left font-bold">
        <th v-if="showIdColumn" class="p-3" scope="col">#</th>
        <th v-for="col in data.columns" :key="col.name" class="p-2" scope="col">
          {{ col.title }}
        </th>
        <th v-if="showAction" class="p-3" scope="col">Action</th>
      </tr>
      <tr v-for="td in data.data" :key="td.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td v-if="showIdColumn" class="p-3 text-justify border-t">
          {{ td.id }}
        </td>
        <td v-for="col in data.columns" :key="col.name" class="p-2 text-justify border-t">
          <a
            v-if="col.href"
            class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600"
            :href="td[col.href]"
            >{{ td[col.name] }}</a
          >
          <span v-else>{{ td[col.name] }}</span>
        </td>
        <td v-if="showAction" class="p-3 text-center border-t space-x-2">
          <template v-for="act in td.action" :key="act.title">
            <ActionBtn
              :title="act.title"
              :class-name="act.className"
              :btn-class-name="act.btnClassName"
              :href="act.href"
              @btnClicked="
                ;(activeItemId = td.id),
                  (activeModalType = act.type),
                  (activeModalMessage = act.modalMessage || 'Delete?'),
                  (showModal = true)
              "
            />
          </template>
        </td>
      </tr>
    </table>

    <Modal
      v-if="showModal"
      @close="showModal = false"
      @btnClick="
        $emit('modalBtnClick', {
          type: activeModalType,
          id: activeItemId,
        }),
          (showModal = false)
      "
    >
      <div class="font-medium leading-none">{{ activeModalMessage }}</div>
    </Modal>
  </div>
  <div class="mt-6">
    <Pagination v-if="showPagination" :data="data" @fetchData="$emit('fetchData', $event)" />
  </div>
</template>

<script lang="ts">
  import { computed, ref, toRefs, defineComponent } from 'vue'

  import ActionBtn from '@/components/ActionBtn.vue'
  import Modal from '@/components/Modal.vue'
  import Pagination from '@/components/Pagination.vue'

  export default defineComponent({
    props: {
      data: { type: Object, required: true },
      showIdColumn: { type: Boolean, default: true },
      showAction: { type: Boolean, default: false },
    },
    components: {
      ActionBtn,
      Modal,
      Pagination,
    },
    emits: ['fetchData', 'modalBtnClick'],
    setup(props) {
      const { data } = toRefs(props)
      const showModal = ref(false)
      const activeItemId = ref(-1)
      const activeModalType = ref('')
      const activeModalMessage = ref('')

      const showPagination = computed(
        () => Object.prototype.hasOwnProperty.call(data.value, 'links') && data.value.links.length > 3
      )

      return {
        activeItemId,
        activeModalType,
        activeModalMessage,
        showPagination,
        showModal,
      }
    },
  })
</script>
