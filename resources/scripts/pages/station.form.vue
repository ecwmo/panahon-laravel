<template layout>
  <Form
    title="Stations"
    basePath="stations"
    :itemName="form?.name"
    :formData="form"
    :showDelete="form?.id !== undefined && isAdmin"
    :showSubmitBtn="isAdmin"
    :isUpdate="form?.id !== undefined"
  >
    <div class="p-8 flex flex-wrap">
      <div class="mb-3 w-full">
        <label for="name" class="form-label">Station Name</label>
        <input type="text" class="form-control" id="name" placeholder="Station Name" name="name" v-model="form.name" />
        <span v-if="form.errors.name" class="form-error" role="alert">
          {{ form.errors.name }}
        </span>
      </div>

      <div class="flex mb-3 space-x-2 w-full">
        <div class="w-1/3">
          <label for="lat" class="form-label">Latitude</label>
          <input type="text" class="form-control" id="lat" placeholder="Lat" name="lat" v-model="form.lat" />
          <span v-if="form.errors.lat" class="form-error" role="alert">
            {{ form.errors.lat }}
          </span>
        </div>
        <div class="w-1/3">
          <label for="lon" class="form-label">Longitude</label>
          <input type="text" class="form-control" id="lon" placeholder="Lon" name="lon" v-model="form.lon" />
          <span v-if="form.errors.lon" class="form-error" role="alert">
            {{ form.errors.lon }}
          </span>
        </div>
        <div class="w-1/3">
          <label for="elevation" class="form-label">Elevation</label>
          <input
            type="text"
            class="form-control"
            id="elevation"
            placeholder="Elevation"
            name="elevation"
            v-model="form.elevation"
          />
          <span v-if="form.errors.elevation" class="form-error" role="alert">
            {{ form.errors.elevation }}
          </span>
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
            v-model="form.station_type"
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
            v-model="form.mobile_number"
          />
          <span v-if="form.errors.mobile_number" class="form-error" role="alert">
            {{ form.errors.mobile_number }}
          </span>
        </div>
      </div>

      <div class="flex mb-3 space-x-2 w-full">
        <div class="w-2/5">
          <label for="status" class="form-label">Status</label>
          <select class="form-control" id="status" name="status" aria-label="Station Status" v-model="form.status">
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
            v-model="form.date_installed"
          />
          <span v-if="form.errors.date_installed" class="form-error" role="alert">
            {{ form.errors.date_installed }}
          </span>
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
          v-model="form.address"
        />
        <span v-if="form.errors.address" class="form-error" role="alert">
          {{ form.errors.address }}
        </span>
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
            v-model="form.province"
          />
          <span v-if="form.errors.province" class="form-error" role="alert">
            {{ form.errors.province }}
          </span>
        </div>
        <div class="w-1/2">
          <label for="region" class="form-label">Region</label>
          <input
            type="text"
            class="form-control"
            id="region"
            placeholder="Region"
            name="region"
            v-model="form.region"
          />
          <span v-if="form.errors.region" class="form-error" role="alert">
            {{ form.errors.region }}
          </span>
        </div>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { PropType } from 'vue'
  import { StationForm } from '@/scripts/types/form'

  const { isAdmin } = useUser()

  const defaultData: StationForm = {
    name: '',
    lat: '',
    lon: '',
    elevation: '',
    mobile_number: '',
    station_type: 'MO',
    station_url: '',
    status: 'INACTIVE',
    address: '',
    province: '',
    region: '',
  }

  const props = defineProps({
    station: {
      type: Object as PropType<StationForm>,
      default: () => ({}),
    },
  })

  const { station: data } = toRefs(props)

  const form = useForm({
    ...defaultData,
    ...data.value,
  })

  const mobileNumberInputEnabled = computed(() => form.station_type === 'SMS')
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
