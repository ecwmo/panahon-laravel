<template layout>
  <Form
    title="Stations"
    propName="station"
    :itemName="form?.name ?? ''"
    :form="form"
    :showDelete="form?.id !== undefined && isAdmin"
    :showSubmitBtn="isAdmin"
    :isUpdate="form?.id !== undefined"
  >
    <div class="p-8 flex flex-wrap">
      <div class="w-full">
        <BreezeLabel for="name" value="Station Name*" />
        <BreezeInput
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.name"
          :disabled="!isAdmin"
          autofocus
        />
        <BreezeInputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="flex mt-4 space-x-2 w-full">
        <div class="w-1/3">
          <BreezeLabel for="lat" value="Latitude" />
          <BreezeInput id="lat" type="text" class="mt-1 block w-full" v-model="form.lat" :disabled="!isAdmin" />
          <BreezeInputError class="mt-2" :message="form.errors.lat" />
        </div>
        <div class="w-1/3">
          <BreezeLabel for="lon" value="Longitude" />
          <BreezeInput id="lon" type="text" class="mt-1 block w-full" v-model="form.lon" :disabled="!isAdmin" />
          <BreezeInputError class="mt-2" :message="form.errors.lon" />
        </div>
        <div class="w-1/3">
          <BreezeLabel for="elevation" value="Elevation" />
          <BreezeInput
            id="elevation"
            type="text"
            class="mt-1 block w-full"
            v-model="form.elevation"
            :disabled="!isAdmin"
          />
          <BreezeInputError class="mt-2" :message="form.errors.elevation" />
        </div>
      </div>

      <div class="flex mt-4 space-x-2 w-full">
        <div class="w-1/5">
          <BreezeLabel for="station_type" value="Type" />
          <SelectInput
            id="station_type"
            class="mt-1 block w-full"
            v-model="form.station_type"
            @update:modelValue="handleStnTypeSelectChange"
            :disabled="!isAdmin"
          >
            <option v-for="opt in stnTypes" :key="opt.name">{{ opt.name }}</option>
          </SelectInput>
        </div>
        <div class="w-1/5">
          <BreezeLabel for="station_type2" value="Type2" />
          <SelectInput
            id="station_type2"
            class="mt-1 block w-full"
            v-model="form.station_type2"
            :disabled="!isAdmin || !stnType2SelectEnabled"
          >
            <option v-for="opt in stnTypes2" :key="opt">{{ opt }}</option>
          </SelectInput>
        </div>
        <div class="w-3/5">
          <BreezeLabel for="mobile_number" :value="`Mobile Number${mobileNumberRequired ? '*' : ''}`" />
          <BreezeInput
            id="mobile_number"
            type="text"
            class="mt-1 block w-full"
            v-model="form.mobile_number"
            :disabled="!isAdmin"
            placeholder="63XXXXXXXXXX"
          />
          <BreezeInputError class="mt-2" :message="form.errors.mobile_number" />
        </div>
      </div>

      <div v-if="form.station_type === 'MO'" class="mt-4 w-full">
        <BreezeLabel for="station_url" value="API" />
        <BreezeInput
          id="station_url"
          type="text"
          class="mt-1 block w-full"
          v-model="form.station_url"
          placeholder="https://example.com"
          :disabled="!isAdmin"
        />
        <BreezeInputError class="mt-2" :message="form.errors.station_url" />
      </div>

      <div class="flex mt-4 space-x-2 w-full">
        <div class="w-2/5">
          <BreezeLabel for="status" value="Status" />
          <SelectInput id="status" class="mt-1 block w-full" v-model="form.status" :disabled="!isAdmin">
            <option>ONLINE</option>
            <option disabled>OFFLINE</option>
            <option disabled>ERROR</option>
            <option>INACTIVE</option>
          </SelectInput>
        </div>
        <div class="w-3/5">
          <BreezeLabel for="date_installed" value="Date Installed" />
          <BreezeInput
            id="date_installed"
            type="date"
            class="mt-1 block w-full"
            v-model="form.date_installed"
            :disabled="!isAdmin"
          />
          <BreezeInputError class="mt-2" :message="form.errors.date_installed" />
        </div>
      </div>

      <div class="mt-4 w-full">
        <BreezeLabel for="address" value="Address" />
        <BreezeInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" :disabled="!isAdmin" />
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
            :disabled="!isAdmin"
          />
          <BreezeInputError class="mt-2" :message="form.errors.province" />
        </div>
        <div class="w-1/2">
          <BreezeLabel for="region" value="Region" />
          <BreezeInput
            id="region"
            type="text"
            class="mt-1 block w-full"
            v-model="form.region"
            placeholder="Region"
            :disabled="!isAdmin"
          />
          <BreezeInputError class="mt-2" :message="form.errors.region" />
        </div>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
  import { StationFields } from '@/types/form'
  import { isRegex, isRequired, isUrl } from 'intus/rules'

  const { isAdmin } = useUser()

  const stnTypes = [
    { name: 'MO', opts: ['Default', 'Data:Globe', 'Data:Smart'] },
    { name: 'SMS', opts: ['Globe', 'Smart'] },
    { name: 'Others', opts: ['WIFI', 'Test'] },
  ]

  const props = defineProps<{ station: StationFields }>()

  const form = useValidatedForm(props.station, {
    name: [isRequired()],
    mobile_number: [isRegex(/63[0-9]{10}/)],
    station_url: [isUrl()],
  })

  const mobileNumberRequired = computed(() => form.station_type !== 'MO' || form.station_type2 !== 'Default')

  const stnTypes2 = computed(() => stnTypes.find(({ name }) => name === form.station_type)?.opts)

  const stnType2SelectEnabled = computed(() => stnTypes2.value !== undefined)

  const handleStnTypeSelectChange = () => {
    form.station_type2 = stnTypes2.value?.[0] ?? ''
  }
</script>
