@extends('layouts.app')

@section('content')
    <div class="flex items-center min-h-screen bg-white dark:bg-gray-900" x-data="stationForm({{ $station }})">
        <div class=" container mx-auto">
            <div class="max-w-md mx-auto">
                <div class="text-center">
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ $station->id ? 'Update ' . $station->name : 'Add new station' }}</h1>
                </div>
                <div class="m-7">
                    @if (Session::has('success'))
                        <div
                            class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-700 bg-green-100 border border-green-300 ">
                            <div slot="avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mx-2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div class="text-xl font-normal  max-w-full flex-initial">{{ Session::get('success') }}</div>
                            <div class="flex flex-auto flex-row-reverse">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="post"
                        action="{{ $station->id == null ? url('stations') : url('stations/' . $station->id) }}">
                        @isset($station->id)
                            {{ method_field('PATCH') }}
                        @endisset
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Station
                                Name</label>
                            <input type="text"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('name') is-invalid @enderror"
                                placeholder="Station Name" name="name" value="{{ old('name', $station->name) }}"
                                required />
                            @error('name')
                                <span class="mb-3 text-xs text-red-500" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="flex mb-3 space-x-2">
                            <div class="w-1/3">
                                <label for="lat"
                                    class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Latitude</label>
                                <input type="text"
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('lat') is-invalid @enderror"
                                    id="lat" placeholder="Lat" name="lat" value="{{ old('lat', $station->lat) }}" />
                                @error('lat')
                                    <span class="mb-3 text-xs text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="w-1/3">
                                <label for="lon"
                                    class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Longitude</label>
                                <input type="text"
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('lon') is-invalid @enderror"
                                    id="lon" placeholder="Lon" name="lon" value="{{ old('lon', $station->lon) }}" />
                                @error('lon')
                                    <span class="mb-3 text-xs text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="w-1/3">
                                <label for="elevation"
                                    class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Elevation</label>
                                <input type="text"
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('elevation') is-invalid @enderror"
                                    id="elevation" placeholder="Elevation" name="elevation"
                                    value="{{ old('elevation', $station->elevation) }}" />
                                @error('elevation')
                                    <span class="mb-3 text-xs text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex mb-3 space-x-2">
                            <div class="w-2/5">
                                <label for="station_type"
                                    class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Station
                                    Type</label>
                                <select
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                                    id="station_type" @change="toggleMobileNumber()" x-model="station['station_type']"
                                    name="station_type" aria-label="Station Type">
                                    <option>SMS</option>
                                    <option>MO</option>
                                </select>
                            </div>
                            <div class="w-3/5">
                                <label for="mobile_number"
                                    class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Mobile
                                    Number</label>
                                <input type="text"
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('mobile_number') is-invalid @enderror"
                                    :disabled="!mobileNumberInputEnabled" id="mobile_number" placeholder="63XXXXXXXXXX"
                                    name="mobile_number" pattern="63[0-9]{10}"
                                    value="{{ old('mobile_number', $station->mobile_number) }}" />

                                @error('mobile_number')
                                    <span class="mb-3 text-xs text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex mb-3 space-x-2">
                            <div class="w-2/5">
                                <label for="status"
                                    class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Status</label>
                                <select
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                                    id="status" x-model="station['status']" name="status" aria-label="Station Status">
                                    <option>ACTIVE</option>
                                    <option>INACTIVE</option>
                                </select>

                            </div>
                            <div class="w-3/5">
                                <label for="date_installed" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Date
                                    Installed</label>
                                <input type="date"
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('date_installed') is-invalid @enderror"
                                    id="date_installed" placeholder="YYYY-MM-dd" name="date_installed"
                                    value="{{ old('date_installed', $station->date_installed) }}" />

                                @error('date_installed')
                                    <span class="mb-3 text-xs text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Address</label>
                            <input type="text"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('address') is-invalid @enderror"
                                id="address" name="address" placeholder="Address"
                                value="{{ old('address', $station->address) }}" />
                            @error('address')
                                <span class="mb-3 text-xs text-red-500" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="flex mb-4 space-x-2">
                            <div class="w-1/2">
                                <label for="province"
                                    class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Province</label>
                                <input type="text"
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('province') is-invalid @enderror"
                                    id="province" placeholder="Province" name="province"
                                    value="{{ old('province', $station->province) }}" />
                                @error('province')
                                    <span class="mb-3 text-xs text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <label for="region"
                                    class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Region</label>
                                <input type="text"
                                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('region') is-invalid @enderror"
                                    id="region" placeholder="Region" name="region"
                                    value="{{ old('region', $station->region) }}" />
                                @error('region')
                                    <span class="mb-3 text-xs text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit"
                                class="w-full px-3 py-4 text-white bg-blue-500 rounded-md focus:bg-blue-600 focus:outline-none">{{ $station->id ? 'Update' : 'Add' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
