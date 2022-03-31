@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="px-10 py-12">
            <h1 class="text-center font-bold text-3xl">Register</h1>

            <div class="mt-10">
                <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Name</label>
                <input id="name" type="text"
                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('name') is-invalid @enderror"
                    placeholder="John Doe" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="mb-3 text-xs text-red-500" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mt-6">
                <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">E-Mail Address</label>
                <input id="email" type="email"
                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('email') is-invalid @enderror"
                    placeholder="username@domain.com" name="email" value="{{ old('email') }}" required
                    autocomplete="email">
                @error('email')
                    <span class="mb-3 text-xs text-red-500" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mt-6">
                <label for="password" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Password</label>
                <input id="password" type="password"
                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('password') is-invalid @enderror"
                    placeholder="************" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="mb-3 text-xs text-red-500" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mt-6">
                <label for="password-confirm" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Confirm
                    Password</label>
                <input id="password-confirm" type="password"
                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                    placeholder="************" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
            <button type="submit"
                class="flex items-center ml-auto px-7 py-3 font-semibold text-white bg-blue-500 rounded-md hover:bg-amber-400 focus:bg-amber-400 focus:outline-none">Register</button>
        </div>
    </form>
@endsection
