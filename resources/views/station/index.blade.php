@extends('layouts.app')

@section('content')
    <div class="container" x-data="stationForm()">
        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="table-title">
            <div class="row">
                <div class="col">
                    <h2>Station <b>Details</b></h2>
                </div>
                <div class="col-auto">
                    <div class="row">
                        <div class="col">
                            <div class="row g-1">
                                <div class="col">
                                    <form action="{{ route('stations.index') }}" method="GET" role="search">
                                        <div class="input-group">
                                            <button class="btn btn-info" type="submit" title="Search stations">
                                                <span class="fas fa-search"></span>
                                            </button>
                                            <input type="text" class="form-control mr-2" name="q"
                                                placeholder="Search stations" id="q">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('stations.index') }}" class="btn btn-danger">
                                        <span class="fas fa-sync-alt"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @auth
                            @if (Auth::user()->hasRole('ADMIN'))
                                <div class="col-auto">
                                    <a class="btn btn-info" href="{{ route('stations.create') }}" role="button"><i
                                            class="fa fa-plus"></i></a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Install Date</th>
                        @auth
                            @if (Auth::user()->hasRole('ADMIN'))
                                <th scope="col">Action</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stations as $st)
                        <tr>
                            <th scope="row">{{ $st->name }}</th>
                            <td>{{ $st->address }}</td>
                            <td class="text-center">{{ $st->station_type }}</td>
                            <td class="text-center">{{ $st->status }}</td>
                            <td class="text-center">{{ date('Y-m-d', strtotime($st->date_installed)) }}</td>
                            @auth
                                @if (Auth::user()->hasRole('ADMIN'))
                                    <td class="d-flex justify-content-evenly">
                                        <a class="edit" title="Edit" data-bs-toggle="tooltip"
                                            href="{{ url('stations/' . $st->id . '/edit') }}"><i class="fas fa-edit"></i></a>
                                        <a class="ms-2 delete" title="Delete" data-bs-toggle="tooltip"
                                            @click="deleteStation({{ $st->id }})"><i class="fas fa-trash"></i></a>
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
