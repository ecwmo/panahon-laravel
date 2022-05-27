import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
  const user = useStorage('user', {
    name: '',
    email: '',
    roles: <string[]>[],
    token: '',
  })

  const axiosConfig = computed(() => ({
    headers: { Authorization: `Bearer ${user.value.token}` },
  }))

  const login = async (userData: Object) => {
    const {
      data: { token },
    } = await axios.post('/api/login', userData)
    user.value = { ...user.value, token }

    const {
      data: {
        user: { name, email, roles },
      },
    } = await axios.get('/api/auth/user', axiosConfig.value)

    user.value = { ...user.value, name, email, roles }
  }

  const isLoggedIn = computed(() => user?.value?.token?.length > 0)
  const isSuperAdmin = computed(() => user?.value?.roles?.includes('SUPERADMIN'))

  const apiFetch = async (url: string) => await axios.get(url, axiosConfig.value)
  const apiCreate = async (url: string, data: object) => await axios.post(url, data, axiosConfig.value)
  const apiUpdate = async (url: string, data: object) => await axios.patch(url, data, axiosConfig.value)
  const apiDelete = async (url: string) => await axios.delete(url, axiosConfig.value)

  return { user, login, isLoggedIn, isSuperAdmin, apiFetch, apiCreate, apiUpdate, apiDelete }
})
