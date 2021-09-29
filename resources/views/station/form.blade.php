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
                        <div class="alert alert-success text-center">
                            {{ Session::get('success') }}
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
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
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
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
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
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
