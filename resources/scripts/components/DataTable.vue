<template>
  <div>
    <div class="mb-6 flex justify-between items-center">
      <h1 class="font-bold text-3xl">{{ title }}</h1>
      <InertiaLink
        v-if="showActionBtn"
        :href="route(`${basePath}.create`)"
        class="rounded px-3 py-2 m-1 shadow bg-blue-600 border-blue-700 hover:bg-amber-400"
        as="button"
      >
        <i-mdi-plus class="text-white text-lg" />
      </InertiaLink>
    </div>

    <ProtonTable :resource="data">
      <template #cell(status)="{ item: dat }" v-if="basePath === 'stations'">
        <InertiaLink
          :href="`${route(`${basePath}.index`)}/${dat.id}/logs`"
          class="underline text-blue-600 hover:text-blue-800"
        >
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

      <template #cell(actions)="{ item: dat }">
        <div class="space-x-2">
          <InertiaLink
            v-if="showActionBtn"
            :href="`${route(`${basePath}.index`)}/${dat.id}`"
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
  import { Inertia, Method } from '@inertiajs/inertia'

  const props = withDefaults(
    defineProps<{
      title: string
      basePath: string
      data: object
    }>(),
    {
      title: '',
      basePath: '',
    }
  )

  const { isAdmin, isSuperAdmin } = useUser()

  const showActionBtn = computed(() => {
    if (props.basePath === 'stations') {
      return isSuperAdmin.value || isAdmin.value
    } else if (['users', 'roles'].includes(props.basePath)) {
      return isSuperAdmin.value
    }
    return false
  })

  const rolesString = (roles: { name: string }[]) => roles.map((r) => r.name).join(', ')

  const handleDeleteBtnCLick = (id: string) => {
    if (confirm('Are you sure you want to delete this item?')) {
      const url = `${route(`${props.basePath}.index`)}/${id}`
      Inertia.visit(url, { method: Method.DELETE })
    }
  }
</script>
