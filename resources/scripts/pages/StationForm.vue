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
      <div class="w-full">
        <BreezeLabel for="name" value="Station Name" />
        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
        <BreezeInputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="flex mt-4 space-x-2 w-full">
        <div class="w-1/3">
          <BreezeLabel for="lat" value="Latitude" />
          <BreezeInput id="lat" type="text" class="mt-1 block w-full" v-model="form.lat" />
          <BreezeInputError class="mt-2" :message="form.errors.lat" />
        </div>
        <div class="w-1/3">
          <BreezeLabel for="lon" value="Longitude" />
          <BreezeInput id="lon" type="text" class="mt-1 block w-full" v-model="form.lon" />
          <BreezeInputError class="mt-2" :message="form.errors.lon" />
        </div>
        <div class="w-1/3">
          <BreezeLabel for="elevation" value="Elevation" />
          <BreezeInput id="elevation" type="text" class="mt-1 block w-full" v-model="form.elevation" />
          <BreezeInputError class="mt-2" :message="form.errors.elevation" />
        </div>
      </div>

      <div class="flex mt-4 space-x-2 w-full">
        <div class="w-2/5">
          <BreezeLabel for="station_type" value="Station Type" />
          <SelectInput id="station_type" class="mt-1 block w-full" v-model="form.station_type">
            <option>SMS</option>
            <option>MO</option>
          </SelectInput>
        </div>
        <div class="w-3/5">
          <BreezeLabel for="mobile_number" value="Mobile Number" />
          <BreezeInput
            id="mobile_number"
            type="text"
            class="mt-1 block w-full"
            v-model="form.mobile_number"
            :disabled="!mobileNumberInputEnabled"
            placeholder="63XXXXXXXXXX"
            pattern="63[0-9]{10}"
          />
          <BreezeInputError class="mt-2" :message="form.errors.mobile_number" />
        </div>
      </div>

      <div class="flex mt-4 space-x-2 w-full">
        <div class="w-2/5">
          <BreezeLabel for="status" value="Status" />
          <SelectInput id="status" class="mt-1 block w-full" v-model="form.status">
            <option>ACTIVE</option>
            <option>INACTIVE</option>
          </SelectInput>
        </div>
        <div class="w-3/5">
          <BreezeLabel for="date_installed" value="Date Installed" />
          <BreezeInput id="date_installed" type="date" class="mt-1 block w-full" v-model="form.date_installed" />
          <BreezeInputError class="mt-2" :message="form.errors.date_installed" />
        </div>
      </div>

      <div class="mt-4 w-full">
        <BreezeLabel for="address" value="Address" />
        <BreezeInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
        <BreezeInputError class="mt-2" :message="form.errors.address" />
      </div>

      <div class="flex mt-4 space-x-2 w-full">
        <div class="w-1/2">
          <BreezeLabel for="province" value="Province" />
          <BreezeInput
            id="province"
            type="text"
            class="mt-1 block w-full"
            v-model="form.province"
            placeholder="Province"
          />
          <BreezeInputError class="mt-2" :message="form.errors.province" />
        </div>
        <div class="w-1/2">
          <BreezeLabel for="region" value="Region" />
          <BreezeInput id="region" type="text" class="mt-1 block w-full" v-model="form.region" placeholder="Region" />
          <BreezeInputError class="mt-2" :message="form.errors.region" />
        </div>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { StationForm } from '@/types/form'

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

  const props = defineProps<{ station?: StationForm }>()

  const form = useForm({
    ...defaultData,
    ...props.station,
  })

  const mobileNumberInputEnabled = computed(() => form.station_type === 'SMS')
</script>
