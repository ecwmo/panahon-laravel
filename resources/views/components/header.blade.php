<nav class="flex flex-wrap justify-between items-center bg-white shadow-lg px-2 md:px-6 py-2">
    <div class="block md:hidden flex items-center flex-no-shrink mr-6">
        {{-- <img src="@/assets/logo.png" alt="Logo" class="h-8 w-8 md:h-10 md:w-10 mr-2" /> --}}
        <span class="font-semibold text-gray-900 text-lg md:text-2xl">{{ config('app.name', 'Laravel') }}</span>
    </div>
    <div class="flex md:hidden">
        <button @click="toggle"
            class="
            flex
            items-center
            px-3
            py-2
            border
            rounded
            hover:text-white hover:border-white hover:bg-black
          ">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
            </svg>
        </button>
    </div>
    <div :class="open ? 'relative w-full' : 'hidden'" class="md:flex">
        <div class="
            flex flex-col flex-grow
            items-center
            md:flex-row md:justify-end
          "
            :class="open ? 'absolute right-0 bg-white shadow-lg' : ''">
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
                <a id="navbarDropdown" class="p-2 font-semibold text-gray-500 hover:text-blue-500 transition duration-300"
                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
        </div>
    </div>
</nav>
