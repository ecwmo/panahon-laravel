@extends('layouts.app')

@section('content')
    <div class="flex items-center min-h-screen bg-white dark:bg-gray-900">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto my-10">
                <div class="text-center">
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">{{ __('Register') }}</h1>
                </div>

                <div class="m-7">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="name"
                                class="block mb-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Name') }}</label>
                            <input id="name" type="text"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('name') is-invalid @enderror"
                                placeholder="John Doe" name="name" value="{{ old('name') }}" required autocomplete="name"
                                autofocus>
                            @error('name')
                                <span class="mb-3 text-xs text-red-500" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email"
                                class="block mb-2 text-sm text-gray-600 dark:text-gray-400">{{ __('E-Mail Address') }}</label>
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

                        <div class="mb-6">
                            <label for="password"
                                class="block mb-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('password') is-invalid @enderror"
                                placeholder="************" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="mb-3 text-xs text-red-500" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password-confirm"
                                class="block mb-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                                placeholder="************" name="password_confirmation" required
                                autocomplete="new-password">
                        </div>

                        <div class="mb-6">
                            <button type="submit"
                                class="w-full px-3 py-4 text-white bg-blue-500 rounded-md focus:bg-blue-600 focus:outline-none">{{ __('Register') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
