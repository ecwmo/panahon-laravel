@extends('layouts.app')

@section('content')
<div class="container" x-data="stationForm({{ $station }})">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header fs-2">{{ $station->id ? "Update ".$station->name : "Add new station" }}</div>
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success text-center">
                            {{Session::get('success')}}
                        </div>
                    @endif

                    <form method="post"
                        action="{{ $station->id == null ? url('stations') :  url('stations/'.$station->id)}}"
                        >
                        @isset($station->id)
                        {{ method_field('PATCH')}}
                        @endisset
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Station Name" name="name"
                                value="{{ old('name', $station->name) }}"
                                required/>
                            <label for="name">Station Name</label>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('lat') is-invalid @enderror"
                                        id="lat" placeholder="Lat" name="lat"
                                        value="{{ old('lat', $station->lat) }}" />
                                    <label for="lat">Latitude</label>
                                    @error('lat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('lon') is-invalid @enderror"
                                        id="lon" placeholder="Lon" name="lon"
                                        value="{{ old('lon', $station->lon) }}" />
                                    <label for="lon">Longitude</label>
                                    @error('lon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('elevation') is-invalid @enderror"
                                        id="elevation" placeholder="Elevation" name="elevation"
                                        value="{{ old('elevation', $station->elevation)  }}" />
                                    <label for="elevation">Elevation</label>
                                    @error('elevation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                    <select class="form-select" id="station_type"
                                        @change="toggleMobileNumber()"
                                        x-model="station['station_type']"
                                        name="station_type"
                                        aria-label="Station Type">
                                        <option>SMS</option>
                                        <option>MO</option>
                                    </select>
                                    <label for="station_type">Station Type</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('mobile_number') is-invalid @enderror"
                                        :disabled="!mobileNumberInputEnabled"
                                        id="mobile_number" placeholder="63XXXXXXXXXX" name="mobile_number"
                                        pattern="63[0-9]{10}"
                                        value="{{ old('mobile_number', $station->mobile_number) }}" />
                                    <label for="mobile_number">Mobile Number</label>
                                    @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                    <select class="form-select" id="status"
                                        x-model="station['status']"
                                        name="status"
                                        aria-label="Station Status">
                                        <option>ACTIVE</option>
                                        <option>INACTIVE</option>
                                    </select>
                                    <label for="status">Status</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="date"
                                        class="form-control @error('date_installed') is-invalid @enderror"
                                        id="date_installed" placeholder="YYYY-MM-dd" name="date_installed"
                                        value="{{ old('date_installed', $station->date_installed) }}" />
                                    <label for="date_installed">Date Installed</label>
                                    @error('date_installed')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text"
                                class="form-control @error('address') is-invalid @enderror"
                                id="address" name="address" placeholder="Address"
                                value="{{ old('address', $station->address) }}" />
                            <label for="address">Address</label>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('province') is-invalid @enderror"
                                        id="province" placeholder="Province" name="province"
                                        value="{{ old('province', $station->province) }}" />
                                    <label for="province">Province</label>
                                    @error('province')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('region') is-invalid @enderror"
                                        id="region" placeholder="Region" name="region"
                                        value="{{ old('region', $station->region) }}" />
                                    <label for="region">Region</label>
                                    @error('region')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ $station->id ? "Update" : "Add" }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
