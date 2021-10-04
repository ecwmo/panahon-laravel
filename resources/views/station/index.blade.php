@extends('layouts.app')

@section('content')
    <div class="flex flex-col space-y-2" x-data="stationForm()">
        <div class="flex justify-between items-end p-2">
            <h2 class="text-2xl">Station <span class="font-bold">Details</span></h2>
            <div class="flex">
                <div class="flex">
                    <form action="{{ route('stations.index') }}" method="GET" role="search">
                        <div class="input-group">
                            <button class="rounded px-3 py-2 m-1 shadow-lg bg-blue-500 border-blue-600" type="submit"
                                title="Search stations">
                                <span class="fas fa-search"></span>
                            </button>
                            <input type="text" class="rounded px-3 py-2 shadow-lg mr-2" name="q"
                                placeholder="Search stations" id="q">
                        </div>
                    </form>
                </div>
                <a href="{{ route('stations.index') }}" class="rounded px-3 py-2 m-1 shadow-lg bg-red-500 border-red-600">
                    <span class="fas fa-sync-alt"></span>
                </a>
                @auth
                    @if (Auth::user()->hasRole('ADMIN'))
                        <a class="rounded px-3 py-2 m-1 shadow-lg bg-blue-600 border-blue-700"
                            href="{{ route('stations.create') }}" role="button">
                            <i class="fa fa-plus"></i></a>
                    @endif
                @endauth
            </div>
        </div>
        <div class="flex justify-center">
            <table class="space-y-6 text-sm">
                <thead>
                    <tr class="text-center">
                        <th class="p-2 border border-gray-300" scope="col"> </th>
                        <th class="p-2 border border-gray-300" scope="col">Name</th>
                        <th class="p-2 border border-gray-300" scope="col">Address</th>
                        <th class="p-2 border border-gray-300" scope="col">Type</th>
                        <th class="p-2 border border-gray-300" scope="col">Status</th>
                        <th class="p-2 border border-gray-300" scope="col">Install Date</th>
                        @auth
                            @if (Auth::user()->hasRole('ADMIN'))
                                <th class="p-2 border border-gray-300" scope="col">Action</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stations as $st)
                        <tr>
                            <th class="p-2 text-justify border border-gray-300" scope="row">{{ $st->id }}</th>
                            <td class="p-2 text-justify border border-gray-300">{{ $st->name }}</td>
                            <td class="p-2 text-justify border border-gray-300">{{ $st->address }}</td>
                            <td class="p-2 text-center border border-gray-300">{{ $st->station_type }}</td>
                            <td class="p-2 text-center border border-gray-300">{{ $st->status }}</td>
                            <td class="p-2 text-center border border-gray-300">
                                {{ date('Y-m-d', strtotime($st->date_installed)) }}</td>
                            @auth
                                @if (Auth::user()->hasRole('ADMIN'))
                                    <td class="p-2 text-center border border-gray-300 space-x-2">
                                        <a class="stroke-current hover:text-blue-600" title="Edit"
                                            href="{{ url('stations/' . $st->id . '/edit') }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="stroke-current hover:text-red-600" title="Delete" href="#"
                                            @click.prevent="deleteStation({{ $st->id }})"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                @endif
                            @endauth
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <!-- For Default pagination user -->
            {{-- <div>{{ $stations->links() }}</div> --}}

            <!-- For Custom pagination User -->
            <div>{{ $stations->links('components.pagination') }}</div>
        </div>

        <!-- Modal -->
        @auth
            @if (Auth::user()->hasRole('ADMIN'))
                <div class="h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50"
                    aria-labelledby="deleteModalLabel" x-show="modalIsVisible" x-cloak>
                    <div class="relative flex flex-col p-8 bg-white shadow-md hover:shodow-lg rounded-2xl">
                        <div class="absolute top-1 right-1 p-2 cursor-pointer" @click="closeModal()">
                            <svg class=" w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-16 h-16 rounded-2xl p-3 border border-blue-100 text-blue-400 bg-blue-50"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex flex-col ml-3">
                                    <div class="font-medium leading-none">Delete this station?</div>
                                </div>
                            </div>
                            <form x-bind:action="`{{ url('stations') }}/${station.id}`" method="post">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="flex-no-shrink bg-red-500 px-5 ml-4 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full"
                                    type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>
@endsection
