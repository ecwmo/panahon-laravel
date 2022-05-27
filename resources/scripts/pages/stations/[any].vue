<template>
  <Form
    title="Stations"
    :itemName="station?.name"
    :showDelete="station?.id !== undefined"
    :isUpdate="station?.id !== undefined"
    @formSubmit="handleFormSubmit"
    @delete="handleDelete"
  >
    <div class="p-8 flex flex-wrap">
      <div class="mb-3 w-full">
        <label for="name" class="form-label">Station Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          placeholder="Station Name"
          name="name"
          v-model="station.name"
        />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.name" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="flex mb-3 space-x-2 w-full">
        <div class="w-1/3">
          <label for="lat" class="form-label">Latitude</label>
          <input type="text" class="form-control" id="lat" placeholder="Lat" name="lat" v-model="station.lat" />
          <template v-if="errors">
            <span class="form-error" role="alert" v-for="(e, i) in errors.lat" :key="i">
              {{ e }}
            </span>
          </template>
        </div>
        <div class="w-1/3">
          <label for="lon" class="form-label">Longitude</label>
          <input type="text" class="form-control" id="lon" placeholder="Lon" name="lon" v-model="station.lon" />
          <template v-if="errors">
            <span class="form-error" role="alert" v-for="(e, i) in errors.lon" :key="i">
              {{ e }}
            </span>
          </template>
        </div>
        <div class="w-1/3">
          <label for="elevation" class="form-label">Elevation</label>
          <input
            type="text"
            class="form-control"
            id="elevation"
            placeholder="Elevation"
            name="elevation"
            v-model="station.elevation"
          />
          <template v-if="errors">
            <span class="form-error" role="alert" v-for="(e, i) in errors.elevation" :key="i">
              {{ e }}
            </span>
          </template>
        </div>
      </div>

      <div class="flex mb-3 space-x-2 w-full">
        <div class="w-2/5">
          <label for="station_type" class="form-label">Station Type</label>
          <select
            class="form-control"
            id="station_type"
            name="station_type"
            aria-label="Station Type"
            v-model="station.station_type"
          >
            <option>SMS</option>
            <option>MO</option>
          </select>
        </div>
        <div class="w-3/5">
          <label for="mobile_number" class="form-label">Mobile Number</label>
          <input
            type="text"
            class="form-control"
            :disabled="!mobileNumberInputEnabled"
            id="mobile_number"
            placeholder="63XXXXXXXXXX"
            name="mobile_number"
            pattern="63[0-9]{10}"
            v-model="station.mobile_number"
          />
          <template v-if="errors">
            <span class="form-error" role="alert" v-for="(e, i) in errors.mobile_number" :key="i">
              {{ e }}
            </span>
          </template>
        </div>
      </div>

      <div class="flex mb-3 space-x-2 w-full">
        <div class="w-2/5">
          <label for="status" class="form-label">Status</label>
          <select class="form-control" id="status" name="status" aria-label="Station Status" v-model="station.status">
            <option>ACTIVE</option>
            <option>INACTIVE</option>
          </select>
        </div>
        <div class="w-3/5">
          <label for="date_installed" class="form-label">Date Installed</label>
          <input
            type="date"
            class="form-control"
            id="date_installed"
            placeholder="YYYY-MM-dd"
            name="date_installed"
            v-model="station.date_installed"
          />
          <template v-if="errors">
            <span class="form-error" role="alert" v-for="(e, i) in errors.date_installed" :key="i">
              {{ e }}
            </span>
          </template>
        </div>
      </div>

      <div class="mb-3 w-full">
        <label for="address" class="form-label">Address</label>
        <input
          type="text"
          class="form-control"
          id="address"
          name="address"
          placeholder="Address"
          v-model="station.address"
        />
        <template v-if="errors">
          <span class="form-error" role="alert" v-for="(e, i) in errors.address" :key="i">
            {{ e }}
          </span>
        </template>
      </div>

      <div class="flex space-x-2 w-full">
        <div class="w-1/2">
          <label for="province" class="form-label">Province</label>
          <input
            type="text"
            class="form-control"
            id="province"
            placeholder="Province"
            name="province"
            v-model="station.province"
          />
          <template v-if="errors">
            <span class="form-error" role="alert" v-for="(e, i) in errors.province" :key="i">
              {{ e }}
            </span>
          </template>
        </div>
        <div class="w-1/2">
          <label for="region" class="form-label">Region</label>
          <input
            type="text"
            class="form-control"
            id="region"
            placeholder="Region"
            name="region"
            v-model="station.region"
          />
          <template v-if="errors">
            <span class="form-error" role="alert" v-for="(e, i) in errors.region" :key="i">
              {{ e }}
            </span>
          </template>
        </div>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { Station, StationFormError } from '@/types/station'

  const route = useRoute()
  const router = useRouter()
  const authStore = useAuthStore()
  const itemId = ref(-1)

  const station = ref(<Station>{
    name: '',
    address: '',
  })
  const errors = ref(<StationFormError>{})

  const baseUrl = computed(() => `/${route.path.split('/')[1]}`)

  const mobileNumberInputEnabled = computed(() => station.value.station_type === 'SMS')

  const fetchData = async () => {
    const { data } = await authStore.apiFetch(`/api${baseUrl.value}/${itemId.value}`)
    station.value = data
  }

  const handleFormSubmit = async (actionType: string) => {
    let res
    if (actionType === 'update') {
      res = await authStore
        .apiUpdate(`/api${baseUrl.value}/${itemId.value}`, station.value)
        .catch(({ response }) => response)
    } else {
      res = await authStore.apiCreate(`/api${baseUrl.value}`, station.value).catch(({ response }) => response)
    }
    if (res.status === 200) {
      router.push(`${baseUrl.value}/${itemId.value}`)
    } else if (res.status === 201) {
      router.push(`${baseUrl.value}/${res.data.id}`)
    } else {
      errors.value = res.data.errors
    }
  }

  const handleDelete = async () => {
    if (confirm('Are you sure you want to delete this station?')) {
      const res = await authStore.apiDelete(`/api${baseUrl.value}/${itemId.value}`)
      if (res.status === 200) {
        router.push(baseUrl.value)
      }
    }
  }

  onMounted(() => {
    const param = <string>route.params['any']
    itemId.value = isNaN(+param) ? -1 : +param
    if (itemId.value >= 0) {
      fetchData()
    }
  })
</script>

<style lang="sass" scoped>
  .form-label
      @apply block mb-2 text-sm text-gray-600
  .form-control
      @apply w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md
      &:focus
          @apply outline-none ring ring-blue-100 border-blue-300
  .form-error
      @apply mb-3 text-xs text-red-500
</style>
