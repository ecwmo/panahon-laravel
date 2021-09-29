@extends('layouts.app')

@section('content')
    <div class="flex items-center min-h-screen bg-white dark:bg-gray-900" x-data="roleForm({{ $role }})">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto">
                <div class="text-center">
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ $role->id ? 'Update ' . $role->name : 'Add new role' }}</h1>
                </div>
                <div class="m-7">
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <form method="post" action="{{ $role->id == null ? url('roles') : url('roles/' . $role->id) }}">
                        @isset($role->id)
                            {{ method_field('PATCH') }}
                        @endisset
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Role Name</label>
                            <input type="text"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 text-uppercase @error('name') is-invalid @enderror"
                                placeholder="Role Name" name="name" value="{{ old('name', $role->name) }}" required />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description"
                                class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Description</label>
                            <input type="text"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('description') is-invalid @enderror"
                                id="description" name="description" placeholder="Description"
                                value="{{ old('description', $role->description) }}" />
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit"
                                class="w-full px-3 py-4 text-white bg-blue-500 rounded-md focus:bg-blue-600 focus:outline-none">{{ $role->id ? 'Update' : 'Add' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
