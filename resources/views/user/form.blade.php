@extends('layouts.app')

@section('content')
    <div class="container"
        x-data="userForm({{ $user }}, {{ $roles }}, {{ old('roles') ? json_encode(old('roles')) : $userRoleIds }})">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header fs-2">{{ $user->id ? 'Update ' . $user->name : 'Add new user' }}</div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        <form method="post" action="{{ $user->id == null ? url('users') : url('users/' . $user->id) }}">
                            @isset($user->id)
                                {{ method_field('PATCH') }}
                            @endisset
                            @csrf

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="User Name" name="name" value="{{ old('name', $user->name) }}" required />
                                <label for="name">User Name</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email" name="email" value="{{ old('email', $user->email) }}" required />
                                <label for="email">Email</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password" name="password" {{ $user->id ? '' : 'required' }} />
                                <label for="password">Password</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3" @mouseleave="roleSelectShow=false">
                                <div class="form-floating input-group">
                                    <input type="text" class="form-control" placeholder="Roles" id="roles"
                                        @focus="roleSelectShow=true" :value="userRoleNames" readonly />
                                    <button class="btn btn-outline-secondary" type="button" id="roleDrpDwnBtn"
                                        @click="roleSelectShow=!roleSelectShow">
                                        <i class="fas" :class="roleSelectShow ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                    </button>
                                    <label for="roles">Roles</label>
                                </div>
                                <select class="form-select" x-model="userRoleIds" name="roles[]" x-show="roleSelectShow"
                                    @blur="roleSelectShow=false" multiple x-cloak>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ $user->id ? 'Update' : 'Add' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
