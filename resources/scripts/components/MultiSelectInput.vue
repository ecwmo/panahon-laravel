<template>
  <div class="w-full flex">
    <input
      id="roles"
      type="text"
      class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-l-md shadow-sm w-full"
      @focus="showDrpDwn = true"
      :value="valueNames"
      readonly
    />
    <button
      class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-400 active:bg-amber-400 focus:outline-none focus:border-amber-600 focus:shadow-outline-gray transition ease-in-out duration-150"
      type="button"
      id="roleDrpDwnBtn"
      @click="showDrpDwn = !showDrpDwn"
    >
      <i class="fas" :class="showDrpDwn ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
    </button>
  </div>
  <select
    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm w-full"
    v-model="selected"
    @change="handelChange"
    @blur="showDrpDwn = false"
    v-show="showDrpDwn"
    multiple
  >
    <option v-for="d in data" :key="d.name" :value="d.value">
      {{ d?.name }}
    </option>
  </select>
</template>

<script setup lang="ts">
  import { SelectOption } from '@/types/form'
  interface Props {
    modelValue?: SelectOption['value'][]
    data: SelectOption[]
  }

  const props = defineProps<Props>()
  const emit = defineEmits(['update:modelValue'])

  const selected = ref([] as SelectOption['value'][])
  const valueNames = ref([] as string[])
  const showDrpDwn = ref(false)

  const { modelValue, data } = toRefs(props)

  const handelChange = () => {
    emit('update:modelValue', selected.value)

    valueNames.value = selected.value?.map(
      (id: SelectOption['value']) => data.value?.filter((d: SelectOption) => d.value === id)[0]['name']
    )
  }

  onMounted(() => {
    selected.value = modelValue?.value ?? ([] as SelectOption['value'][])
    valueNames.value = selected.value?.map(
      (id: SelectOption['value']) => data.value?.filter((d: SelectOption) => d.value === id)[0]['name']
    )
  })
</script>
