@extends('layouts.app')

@section('content')
    <div class="flex flex-col space-y-2">
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

        <div class="flex flex-col items-center">
            <data-table :fetch-url="'{{ route('roles.table') }}'"
                :columns="[{'name': 'name', 'title': 'Name'}, {'name': 'description', 'title': 'Description'}]"
                :base-url="'{{ url('roles') }}'" :show-action="@json(Auth::user()->hasRole('SUPERADMIN'))"
                :delete-modal-message="'Delete this role?'">
            </data-table>

            <!-- For Default pagination user -->
            {{-- <div>{{ $roles->links() }}</div> --}}

            <!-- For Custom pagination User -->
            <div>{{ $roles->links('components.pagination') }}</div>
        </div>
    </div>
@endsection
