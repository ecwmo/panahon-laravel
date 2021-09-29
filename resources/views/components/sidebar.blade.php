<aside id="sidebar"
    class="sidebar w-64 md:shadow transform -translate-x-full md:translate-x-0 transition-transform duration-150 ease-in bg-blue-500">
    <div class="sidebar-header flex items-center justify-center py-4">
        <div class="inline-flex">
            <a href="#" class="inline-flex flex-row items-center">
                {{-- <img src="@/assets/logo.png" alt="Logo" class="h-8 w-8 md:h-10 md:w-10 mr-2" /> --}}
                <span
                    class="leading-10 text-gray-100 text-2xl font-bold ml-1 uppercase">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>
    </div>
    <div class="sidebar-content px-4 py-6">
        <ul class="flex flex-col w-full">
            <li class="my-px">
                <a href="{{ url('/') }}"
                    class="flex flex-row items-center h-10 px-3 rounded-lg {{ request()->is('/') ? 'text-gray-700 bg-gray-100' : 'text-gray-300 hover:bg-gray-100 hover:text-gray-700' }}"
                    aria-current="true">
                    <i
                        class="flex items-center justify-center text-lg text-gray-400 stroke-current fas fa-tachometer-alt fa-fw me-3"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li class="my-px">
                <a href="{{ url('stations') }}"
                    class="flex flex-row items-center h-10 px-3 rounded-lg {{ request()->routeIs('stations.*') ? 'text-gray-700 bg-gray-100' : 'text-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                    <i class="flex items-center justify-center text-lg text-gray-400 fas fa-umbrella fa-fw me-3"></i>
                    <span class="ml-3">Weather Stations</span>
                    {{-- <span
                        class="flex items-center justify-center text-xs text-red-500 font-semibold bg-red-100 h-6 px-2 rounded-full ml-auto">1k</span> --}}
                </a>
            </li>
            @auth
                @if (Auth::user()->hasRole('SUPERADMIN'))
                    <li class="my-px">
                        <a href="{{ url('users') }}"
                            class="flex flex-row items-center h-10 px-3 rounded-lg {{ request()->routeIs('users.*') ? 'text-gray-700 bg-gray-100' : 'text-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                            <i class="flex items-center justify-center text-lg text-gray-400 fas fa-user fa-fw me-3"></i>
                            <span class="ml-3">User</span>
                            {{-- <span
                            class="flex items-center justify-center text-xs text-red-500 font-semibold bg-red-100 h-6 px-2 rounded-full ml-auto">1k</span> --}}
                        </a>
                    </li>
                    <li class="my-px">
                        <a href="{{ url('roles') }}"
                            class="flex flex-row items-center h-10 px-3 rounded-lg {{ request()->routeIs('roles.*') ? 'text-gray-700 bg-gray-100' : 'text-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                            <i
                                class="flex items-center justify-center text-lg text-gray-400 fas fa-user-tag fa-fw me-3"></i>
                            <span class="ml-3">Roles</span>
                            {{-- <span
                            class="flex items-center justify-center text-xs text-red-500 font-semibold bg-red-100 h-6 px-2 rounded-full ml-auto">1k</span> --}}
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</aside>
