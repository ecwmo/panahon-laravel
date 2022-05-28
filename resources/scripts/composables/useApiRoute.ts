import axios from 'axios'

const BASE_URL = import.meta.env.BASE_URL
const API_URL = 'api'

export default () => {
  const route = useRoute()
  const authStore = useAuthStore()

  const axiosConfig = {
    headers: { Authorization: `Bearer ${authStore.user.token}` },
  }

  const apiPath = `${BASE_URL}/${API_URL}/${route.path}`.replace(/\/+/g, '/')

  const apiFetch = async ({ url = apiPath, page = -1 } = {}) => {
    let fetchConfig: object = axiosConfig
    if (page >= 0) {
      fetchConfig = {
        ...axiosConfig,
        params: {
          page,
        },
      }
    }
    return await axios.get(url, fetchConfig)
  }
  const apiShow = async () => await axios.get(apiPath, axiosConfig)
  const apiCreate = async (data: object) => await axios.post(apiPath, data, axiosConfig)
  const apiUpdate = async (data: object) => await axios.patch(apiPath, data, axiosConfig)
  const apiDelete = async () => await axios.delete(apiPath, axiosConfig)

  return { apiPath, apiFetch, apiShow, apiCreate, apiUpdate, apiDelete }
}
