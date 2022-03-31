@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="px-10 py-12">
            <h1 class="text-center font-bold text-3xl">Login</h1>
            <div class="mx-auto mt-6 w-24 border-b-2"></div>
            <div class="mt-10">
                <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">E-Mail Address</label>
                <input id="email" type="email"
                    class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500 @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" placeholder="username@domain.com" required
                    autocomplete="email" autofocus>
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
                    name="password" placeholder="************" required autocomplete="current-password">
                @error('password')
                    <span class="mb-3 text-xs text-red-500" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="mt-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}><span class="ml-2 text-gray-700">Remember Me</span>
                </label>
            </div>
            <div class="mt-6">
                <p class="text-sm text-center text-gray-400">
                    @if (Route::has('password.request'))
                        <a class="text-blue-400 focus:outline-none focus:underline focus:text-blue-500 dark:focus:border-blue-800"
                            href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    @endif
                </p>
            </div>
        </div>

        <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
            <button type="submit"
                class="flex items-center ml-auto px-7 py-3 font-semibold text-white bg-blue-500 rounded-md hover:bg-amber-400 focus:bg-amber-400 focus:outline-none">Login</button>
        </div>
    </form>
@endsection
