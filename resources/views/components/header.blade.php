<v-header title="{{ config('app.name', 'Laravel') }}">
    <!-- Authentication Links -->
    @guest
        @if (Route::has('login'))
            <a class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300"
                href="{{ route('login') }}">{{ __('Login') }}</a>
        @endif

        @if (Route::has('register'))
            <a class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300"
                href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
    @else
        <a id="navbarDropdown" class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300" href="#"
            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    @endguest
</v-header>
