import { defineStore } from 'pinia'
import axios from 'axios'

import { UserForm } from '@/types/form'

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

  const register = async (userData: UserForm) => {
    const res = await axios.post(`${apiPath}/register`, userData).catch(({ response: r }) => r)
    const token = res?.data?.token
    const { name, email } = userData
    if (token) user.value = { ...user.value, token, name, email }
    return res
  }

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

  const logout = async () => {
    const res = await axios.post(`${apiPath}/logout`, {}, axiosConfig.value)
    if (res.status === 200) {
      user.value = {
        name: '',
        email: '',
        roles: <string[]>[],
        token: '',
      }
    }
    return res
  }

  const isLoggedIn = computed(() => user?.value?.token?.length > 0)
  const isSuperAdmin = computed(() => user?.value?.roles?.includes('SUPERADMIN'))
  const isAdmin = computed(() => user?.value?.roles?.includes('ADMIN') || isSuperAdmin.value)

  return { user, register, login, logout, isLoggedIn, isAdmin, isSuperAdmin }
})
