@extends('layouts.app')

@section('content')
    <div class="flex flex-col space-y-2" x-data="roleForm()">
        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="flex justify-between items-end p-2">
            <h2 class="text-2xl">Role <span class="font-bold">Details</span></h2>
            <div class="flex">
                @auth
                    @if (Auth::user()->hasRole('SUPERADMIN'))
                        <a class="rounded px-3 py-2 m-1 shadow-lg bg-blue-600 border-blue-700"
                            href="{{ route('roles.create') }}" role="button">
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
                        <th class="p-2 border border-gray-300" scope="col">Description</th>
                        @auth
                            @if (Auth::user()->hasRole('SUPERADMIN'))
                                <th class="p-2 border border-gray-300" scope="col">Action</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <th class="p-2 text-justify border border-gray-300" scope="row">{{ $role->name }}</th>
                            <td class="p-2 text-justify border border-gray-300">{{ $role->description }}</td>
                            @auth
                                @if (Auth::user()->hasRole('SUPERADMIN'))
                                    <td class="p-2 text-center border border-gray-300 space-x-2">
                                        <a title="Edit" href="{{ url('roles/' . $role->id . '/edit') }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a title="Delete" @click="deleteRole({{ $role->id }})"><i
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
            {{-- <div>{{ $roles->links() }}</div> --}}

            <!-- For Custom pagination User -->
            <div>{{ $roles->links('components.pagination') }}</div>
        </div>

        <!-- Modal -->
        @auth
            @if (Auth::user()->hasRole('SUPERADMIN'))
                <div class="x-modal" x-cloak x-show="modalIsVisible" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm delete</h5>
                                <button type="button" class="btn-close" @click="closeModal()" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this role?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                                <form x-bind:action="`{{ url('roles') }}/${role.id}`" method="post">
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
