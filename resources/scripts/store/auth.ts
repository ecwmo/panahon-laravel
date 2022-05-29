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
    tokenExpiresAt: new Date(),
  })

  const axiosConfig = computed(() => ({
    headers: { Authorization: `Bearer ${user.value.token}` },
  }))

  const apiPath = `${BASE_URL}/${API_URL}`.replace(/\/+/g, '/')

  const register = async (userData: UserForm) => {
    const res = await axios.post(`${apiPath}/register`, userData).catch(({ response: r }) => r)

    try {
      const {
        data: { name, email, roles, access_token, expires_at },
      } = res

      if (email) user.value = { name, email, roles, token: access_token, tokenExpiresAt: new Date(expires_at) }
    } catch {}

    return res
  }

  const login = async (userData: Object) => {
    const res = await axios.post(`${apiPath}/login`, userData).catch(({ response: r }) => r)

    try {
      const {
        data: { name, email, roles, access_token, expires_at },
      } = res

      if (email) user.value = { name, email, roles, token: access_token, tokenExpiresAt: new Date(expires_at) }
    } catch {}

    return res
  }

  const logout = async () => {
    const res = await axios.post(`${apiPath}/logout`, {}, axiosConfig.value)
    if (res.status === 200) {
      user.value = {
        name: '',
        email: '',
        roles: <string[]>[],
        token: '',
        tokenExpiresAt: new Date(),
      }
    }
    return res
  }

  const isLoggedIn = computed(() => user?.value?.token?.length > 0)
  const isSuperAdmin = computed(() => user?.value?.roles?.includes('SUPERADMIN'))
  const isAdmin = computed(() => user?.value?.roles?.includes('ADMIN') || isSuperAdmin.value)

  return { user, register, login, logout, isLoggedIn, isAdmin, isSuperAdmin }
})
