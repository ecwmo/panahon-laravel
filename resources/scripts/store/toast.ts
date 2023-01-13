import { defineStore } from 'pinia'

interface Toast {
  key?: symbol
  message: string
}

export const useToastStore = defineStore('toast', () => {
  const items = ref([] as Toast[])

  const add = (toast: Toast) => items.value.unshift({ ...toast, key: Symbol() })

  const remove = (idx: number) => items.value.splice(idx, 1)

  return { items, add, remove }
})
