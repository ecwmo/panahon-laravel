<template>
  <div>
    <div class="mb-6 flex justify-between items-center">
      <h1 class="font-bold text-3xl">{{ title }}</h1>
      <InertiaLink
        v-if="showActionBtn && createRoute"
        :href="createRoute"
        class="rounded px-3 py-2 m-1 shadow bg-blue-600 border-blue-700 hover:bg-amber-400"
        as="button"
      >
        <i-mdi-plus class="text-white text-lg" />
      </InertiaLink>
    </div>

    <ProtonTable :resource="data">
      <template #cell(status)="{ item: dat }" v-if="basePath === 'stations'">
        <InertiaLink :href="`${route(indexRoute)}/${dat.id}/logs`" class="underline text-blue-600 hover:text-blue-800">
          {{ dat.status }}
        </InertiaLink>
      </template>

      <template #cell(roles)="{ item: dat }" v-if="basePath === 'users'">
        {{ rolesString(dat.roles) }}
      </template>

      <template #cell(station_name)="{ item: dat }" v-if="basePath === 'simcard'">
        <InertiaLink
          :href="`${route('stations.index')}/${dat.station_id}`"
          class="underline text-blue-600 hover:text-blue-800"
        >
          {{ dat.station_name }}
        </InertiaLink>
      </template>

      <template #cell(latest_topup_created_at)="{ item: dat }" v-if="basePath === 'simcard'">
        <div class="space-x-2">
          <span>
            {{ dat.latest_topup_created_at?.split(' ')[0] }}
          </span>
          <InertiaLink
            v-if="
              showActionBtn &&
              dat.latest_topup_created_at &&
              differenceInDays(new Date(dat.latest_topup_created_at), new Date()) <= -25
            "
            href="#"
            class="inline-flex items-center justify-center flex-shrink-0 w-6 h-6 hover:text-blue-500 hover:bg-blue-100 rounded-lg shadow-sm"
            @click.prevent="handleTopupBtnClick(dat.mobile_number)"
          >
            <IMdiCashPlus class="text-xs" />
          </InertiaLink>
        </div>
      </template>

      <template #cell(actions)="{ item: dat }">
        <div class="space-x-2">
          <InertiaLink
            v-if="showActionBtn"
            :href="`${route(indexRoute)}/${dat.id}`"
            class="inline-flex items-center justify-center flex-shrink-0 w-6 h-6 hover:text-blue-500 hover:bg-blue-100 rounded-lg shadow-sm"
          >
            <IMdiPencil class="text-xs" />
          </InertiaLink>
          <InertiaLink
            v-if="showActionBtn"
            href="#"
            class="inline-flex items-center justify-center flex-shrink-0 w-6 h-6 hover:text-red-500 hover:bg-red-100 rounded-lg shadow-sm"
            @click.prevent="handleDeleteBtnCLick(dat.id)"
          >
            <IMdiTrashCan class="text-xs" />
          </InertiaLink>
        </div>
      </template>
    </ProtonTable>
  </div>
</template>

<script setup lang="ts">
  import { differenceInDays } from 'date-fns'

  withDefaults(
    defineProps<{
      title: string
      data: object
    }>(),
    {
      title: '',
    }
  )

  const { isAdmin, isSuperAdmin } = useUser()

  const showActionBtn = computed(() => {
    if (['stations', 'simcard'].includes(basePath.value)) {
      return isAdmin.value
    } else if (['users', 'roles'].includes(basePath.value)) {
      return isSuperAdmin.value
    }
    return false
  })

  const rolesString = (roles: { name: string }[]) => roles.map((r) => r.name).join(', ')

  const basePath = computed(() => indexRoute.value.replace('.index', ''))

  const indexRoute = computed(() => route().current() ?? '')

  const createRoute = computed(() => {
    const routeName = indexRoute.value.replace('index', 'create')
    return route().has(routeName) && route(routeName)
  })

  const handleDeleteBtnCLick = (id: string) => {
    if (confirm('Are you sure you want to delete this item?')) {
      const url = `${route(indexRoute.value)}/${id}`
      const form = useForm({})
      form.delete(url)
    }
  }

  const handleTopupBtnClick = (mobileNum: string) => {
    const form = useForm({
      rewardRequest: {
        address: mobileNum.substring(2),
      },
    })
    if (confirm('Are you sure you want to send load to this number?')) {
      const url = route('simcard.index')
      form.post(url)
    }
  }
</script>
