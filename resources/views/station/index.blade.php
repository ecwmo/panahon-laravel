@extends('layouts.app')

@section('content')
<div class="container" x-data="stationForm()">
    @if(Session::has('success'))
        <div class="alert alert-success text-center">
            {{Session::get('success')}}
        </div>
    @endif

    <div class="table-title">
        <div class="row">
            <div class="col-sm-8"><h2>Station <b>Details</b></h2></div>
            <div class="col-sm-4">
                <a class="btn btn-info add-new" href="{{ url('admin/stations/create') }}" role="button"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Status</th>
            <th scope="col">Install Date</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($stations as $st)
            <tr>
            <th scope="row">{{ $st->id }}</th>
            <td>{{ $st->name }}</td>
            <td>{{ $st->address }}</td>
            <td>{{ $st->status }}</td>
            <td>{{ date('Y-m-d', strtotime($st->date_installed)) }}</td>
            <td>
                {{-- <a class="add" title="Add" data-toggle="tooltip"><i class="fas fa-plus-square">&#xE03B;</i></a> --}}
                <a class="edit" title="Edit" data-bs-toggle="tooltip" href="{{ url('admin/stations/'.$st->id.'/edit') }}"><i class="fas fa-edit">&#xE254;</i></a>
                <a class="delete" title="Delete" data-bs-toggle="tooltip" @click="deleteStation({{ $st->id }})"><i class="fas fa-trash">&#xE872;</i></a>
            </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div>
        <!-- For Default pagination user -->
        {{-- <div>{{ $stations->links() }}</div> --}}

        <!-- For Custom pagination User -->
        <div>{{ $stations->links('components.pagination') }}</div>
    </div>

    <!-- Modal -->
    <div class="x-modal" x-cloak x-show="modalIsVisible" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                    <form x-bind:action="`{{ url('admin/stations') }}/${station.id}`" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
