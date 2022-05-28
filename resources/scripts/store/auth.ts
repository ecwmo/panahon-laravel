import { defineStore } from 'pinia'
import axios from 'axios'

const BASE_URL = import.meta.env.BASE_URL
const API_URL = 'api'

export const useAuthStore = defineStore('auth', () => {
  const user = useStorage('user', {
    name: '',
    email: '',
    roles: <string[]>[],
    token: '',
  })

  const apiPath = `${BASE_URL}/${API_URL}`.replace(/\/+/g, '/')

  const axiosConfig = computed(() => ({
    headers: { Authorization: `Bearer ${user.value.token}` },
  }))

  const login = async (userData: Object) => {
    const {
      data: { token },
    } = await axios.post(`${apiPath}/login`, userData)
    user.value = { ...user.value, token }

    const {
      data: {
        user: { name, email, roles },
      },
    } = await axios.get(`${apiPath}/auth/user`, axiosConfig.value)

    user.value = { ...user.value, name, email, roles }
  }

  const isLoggedIn = computed(() => user?.value?.token?.length > 0)
  const isAdmin = computed(() => user?.value?.roles?.includes('ADMIN'))
  const isSuperAdmin = computed(() => user?.value?.roles?.includes('SUPERADMIN'))

  return { user, login, isLoggedIn, isAdmin, isSuperAdmin }
})
