<template>
  <div>
    <table class="table-auto space-y-6 text-sm mb-2">
      <thead>
        <tr class="text-center">
          <th v-if="showIdColumn" class="p-2 border border-gray-300" scope="col">#</th>
          <th v-for="col in data.columns" :key="col.name" class="p-2 border border-gray-300" scope="col">
            {{ col.title }}
          </th>
          <th v-if="showAction" class="p-2 border border-gray-300" scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="td in data.data" :key="td.id">
          <td v-if="showIdColumn" class="p-2 text-justify border border-gray-300">
            {{ td.id }}
          </td>
          <td v-for="col in data.columns" :key="col.name" class="p-2 text-justify border border-gray-300">
            <a
              v-if="col.href"
              class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600"
              :href="td[col.href]"
              >{{ td[col.name] }}</a
            >
            <span v-else>{{ td[col.name] }}</span>
          </td>
          <td v-if="showAction" class="p-2 text-center border border-gray-300 space-x-2">
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
      </tbody>
    </table>

    <Pagination v-if="showPagination" :data="data" @fetchData="$emit('fetchData', $event)" />

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
