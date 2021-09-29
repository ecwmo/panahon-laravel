@extends('layouts.app')

@section('content')
    <div class="flex flex-col space-y-2" x-data="stationForm()">
        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                {{ Session::get('success') }}
            </div>
        @endif

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
                            <th class="p-2 text-justify border border-gray-300" scope="row">{{ $st->name }}</th>
                            <td class="p-2 text-justify border border-gray-300">{{ $st->address }}</td>
                            <td class="p-2 text-center border border-gray-300">{{ $st->station_type }}</td>
                            <td class="p-2 text-center border border-gray-300">{{ $st->status }}</td>
                            <td class="p-2 text-center border border-gray-300">
                                {{ date('Y-m-d', strtotime($st->date_installed)) }}</td>
                            @auth
                                @if (Auth::user()->hasRole('ADMIN'))
                                    <td class="p-2 text-center border border-gray-300 space-x-2">
                                        <a title="Edit" href="{{ url('stations/' . $st->id . '/edit') }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a title="Delete" @click="deleteStation({{ $st->id }})"><i
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
                <div class="x-modal" x-cloak x-show="modalIsVisible" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm delete</h5>
                                <button type="button" class="btn-close" @click="closeModal()" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this station?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                                <form x-bind:action="`{{ url('stations') }}/${station.id}`" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>
@endsection
