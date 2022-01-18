<template>
    <div class="flex items-center min-h-screen bg-white dark:bg-gray-900">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto">
                <div class="text-center">
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ station.id ? `Update ${station.name}` : 'Add new station' }}
                    </h1>
                </div>

                <div
                    v-show="success"
                    class="
                        flex
                        justify-center
                        items-center
                        m-1
                        font-medium
                        py-1
                        px-2
                        bg-white
                        rounded-md
                        text-green-700
                        bg-green-100
                        border border-green-300
                    "
                >
                    <div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="100%"
                            height="100%"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-circle w-5 h-5 mx-2"
                        >
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div class="text-xl font-normal max-w-full flex-initial">
                        Updated successfully
                    </div>
                    <div class="flex flex-auto flex-row-reverse">
                        <div @click="success = false">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="100%"
                                height="100%"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="
                                    feather feather-x
                                    cursor-pointer
                                    hover:text-green-400
                                    rounded-full
                                    w-5
                                    h-5
                                    ml-2
                                "
                            >
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="m-7">
                    <form @submit.prevent="handleFormSubmit">
                        <div class="mb-3">
                            <label for="name" class="form-label">Station Name</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Station Name"
                                name="name"
                                :value="station.name"
                                @input="station.name = $event.target.value"
                            />
                            <template v-if="errors">
                                <span
                                    class="form-error"
                                    role="alert"
                                    v-for="(e, i) in errors.name"
                                    :key="i"
                                >
                                    {{ e }}
                                </span>
                            </template>
                        </div>

                        <div class="flex mb-3 space-x-2">
                            <div class="w-1/3">
                                <label for="lat" class="form-label">Latitude</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="lat"
                                    placeholder="Lat"
                                    name="lat"
                                    :value="station.lat"
                                    @input="station.lat = $event.target.value"
                                />
                                <template v-if="errors">
                                    <span
                                        class="form-error"
                                        role="alert"
                                        v-for="(e, i) in errors.lat"
                                        :key="i"
                                    >
                                        {{ e }}
                                    </span>
                                </template>
                            </div>
                            <div class="w-1/3">
                                <label for="lon" class="form-label">Longitude</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="lon"
                                    placeholder="Lon"
                                    name="lon"
                                    :value="station.lon"
                                    @input="station.lon = $event.target.value"
                                />
                                <template v-if="errors">
                                    <span
                                        class="form-error"
                                        role="alert"
                                        v-for="(e, i) in errors.lon"
                                        :key="i"
                                    >
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
                                    :value="station.elevation"
                                    @input="station.elevation = $event.target.value"
                                />
                                <template v-if="errors">
                                    <span
                                        class="form-error"
                                        role="alert"
                                        v-for="(e, i) in errors.elevation"
                                        :key="i"
                                    >
                                        {{ e }}
                                    </span>
                                </template>
                            </div>
                        </div>

                        <div class="flex mb-3 space-x-2">
                            <div class="w-2/5">
                                <label for="station_type" class="form-label">Station Type</label>
                                <select
                                    class="form-control"
                                    id="station_type"
                                    name="station_type"
                                    aria-label="Station Type"
                                    :value="station.station_type"
                                    @change="station.station_type = $event.target.value"
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
                                    :value="station.mobile_number"
                                />
                                <template v-if="errors">
                                    <span
                                        class="form-error"
                                        role="alert"
                                        v-for="(e, i) in errors.mobile_number"
                                        :key="i"
                                    >
                                        {{ e }}
                                    </span>
                                </template>
                            </div>
                        </div>

                        <div class="flex mb-3 space-x-2">
                            <div class="w-2/5">
                                <label for="status" class="form-label">Status</label>
                                <select
                                    class="form-control"
                                    id="status"
                                    name="status"
                                    aria-label="Station Status"
                                    :value="station.status"
                                    @change="station.status = $event.target.value"
                                >
                                    <option>ACTIVE</option>
                                    <option>INACTIVE</option>
                                </select>
                            </div>
                            <div class="w-3/5">
                                <label for="date_installed" class="form-label"
                                    >Date Installed</label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    id="date_installed"
                                    placeholder="YYYY-MM-dd"
                                    name="date_installed"
                                    :value="station.date_installed"
                                    @change="station.date_installed = $event.target.value"
                                />
                                <template v-if="errors">
                                    <span
                                        class="form-error"
                                        role="alert"
                                        v-for="(e, i) in errors.date_installed"
                                        :key="i"
                                    >
                                        {{ e }}
                                    </span>
                                </template>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input
                                type="text"
                                class="form-control"
                                id="address"
                                name="address"
                                placeholder="Address"
                                :value="station.address"
                                @input="station.address = $event.target.value"
                            />
                            <template v-if="errors">
                                <span
                                    class="form-error"
                                    role="alert"
                                    v-for="(e, i) in errors.address"
                                    :key="i"
                                >
                                    {{ e }}
                                </span>
                            </template>
                        </div>

                        <div class="flex mb-4 space-x-2">
                            <div class="w-1/2">
                                <label for="province" class="form-label">Province</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="province"
                                    placeholder="Province"
                                    name="province"
                                    :value="station.province"
                                    @input="station.province = $event.target.value"
                                />
                                <template v-if="errors">
                                    <span
                                        class="form-error"
                                        role="alert"
                                        v-for="(e, i) in errors.province"
                                        :key="i"
                                    >
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
                                    :value="station.region"
                                    @input="station.region = $event.target.value"
                                />
                                <template v-if="errors">
                                    <span
                                        class="form-error"
                                        role="alert"
                                        v-for="(e, i) in errors.region"
                                        :key="i"
                                    >
                                        {{ e }}
                                    </span>
                                </template>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="form-button">
                                {{ station.id ? 'Update' : 'Add' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, toRefs, computed, onMounted } from 'vue';
import axios from 'axios';

export default {
    props: ['data', 'baseUrl'],
    setup(props) {
        const { data, baseUrl } = toRefs(props);
        const station = ref({
            name: '',
            lat: null,
            lon: null,
            elevation: null,
            mobile_number: null,
            date_installed: null,
            address: '',
            province: '',
            region: '',
        });
        const errors = ref({});
        const success = ref(false);

        const mobileNumberInputEnabled = computed(() => station.value.station_type === 'SMS');

        const handleFormSubmit = () => {
            success.value = false;
            if (station.value.id) {
                console.log('patch');
                console.log(station.value);
                axios
                    .patch(`${baseUrl.value}/${station.value.id}`, station.value)
                    .then(() => (success.value = true))
                    .catch(
                        ({
                            response: {
                                data: { errors: err },
                            },
                        }) => (errors.value = err)
                    );
            } else {
                console.log('post');
                console.log(station.value);
                axios
                    .post(baseUrl.value, station.value)
                    .then(() => (success.value = true))
                    .catch(
                        ({
                            response: {
                                data: { errors: err },
                            },
                        }) => (errors.value = err)
                    );
            }
        };

        onMounted(() => {
            if (data.value.id) station.value = data.value;
        });

        return { station, success, errors, mobileNumberInputEnabled, handleFormSubmit };
    },
};
</script>

<style lang="sass" scoped>
.form-label
    @apply block mb-2 text-sm text-gray-600
.form-control
    @apply w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md
    &:focus
        @apply outline-none ring ring-blue-100 border-blue-300
.form-button
    @apply w-full px-3 py-4 text-white bg-blue-500 rounded-md
    &:focus
        @apply bg-blue-600 outline-none
.form-error
    @apply mb-3 text-xs text-red-500
</style>
