@extends('layouts.app')

@section('content')
    <div class="flex items-center min-h-screen bg-white dark:bg-gray-900">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto my-10">
                <div class="text-center">
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">{{ __('Confirm Password') }}
                    </h1>
                </div>

                <div class="m-7">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="password"
                                class="block mb-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500  @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="mb-3 text-xs text-red-500" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <button type="submit"
                                class="w-full px-3 py-4 text-white bg-blue-500 rounded-md focus:bg-blue-600 focus:outline-none">{{ __('Confirm Password') }}</button>
                        </div>

                        <p class="text-sm text-center text-gray-400">
                            @if (Route::has('password.request'))
                                <a class="text-blue-400 focus:outline-none focus:underline focus:text-blue-500 dark:focus:border-blue-800"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
