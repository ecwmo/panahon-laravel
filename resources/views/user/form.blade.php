@extends('layouts.app')

@section('content')
    <div class="flex items-center min-h-screen bg-white dark:bg-gray-900"
        x-data="userForm({{ $user }}, {{ $roles }}, {{ old('roles') ? json_encode(old('roles')) : $userRoleIds }})">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto">
                <div class="text-center">
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ $user->id ? 'Update ' . $user->name : 'Add new user' }}</h1>
                </div>
                <div class="m-7">
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

                        <div class="mb-3">
                            <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">User Name</label>
                            <input type="text"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('name') is-invalid @enderror"
                                placeholder="User Name" name="name" value="{{ old('name', $user->name) }}" required />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Email</label>
                            <input type="email"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('email') is-invalid @enderror"
                                placeholder="Email" name="email" value="{{ old('email', $user->email) }}" required />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password"
                                class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Password</label>
                            <input type="password"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('password') is-invalid @enderror"
                                placeholder="Password" name="password" {{ $user->id ? '' : 'required' }} />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3" @mouseleave="roleSelectShow=false">
                            <label for="roles" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Roles</label>
                            <div class="w-full flex">
                                <input type="text"
                                    class="flex-grow px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-l-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                                    placeholder="Roles" id="roles" @focus="roleSelectShow=true" :value="userRoleNames"
                                    readonly />
                                <button class="px-3 py-2 border bg-blue-300 border-blue-400 rounded-r-md" type="button"
                                    id="roleDrpDwnBtn" @click="roleSelectShow=!roleSelectShow">
                                    <i class="fas"
                                        :class="roleSelectShow ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>

                            </div>
                            <select
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                                x-model="userRoleIds" name="roles[]" x-show="roleSelectShow" @blur="roleSelectShow=false"
                                multiple x-cloak>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit"
                                class="w-full px-3 py-4 text-white bg-blue-500 rounded-md focus:bg-blue-600 focus:outline-none">{{ $user->id ? 'Update' : 'Add' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
