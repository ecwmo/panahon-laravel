@extends('layouts.app')

@section('content')
    <div class="flex flex-col space-y-2">
        <div class="flex justify-between items-end p-2">
            <h2 class="text-2xl">User <span class="font-bold">Details</span></h2>
            <div class="flex">
                @auth
                    @if (Auth::user()->hasRole('SUPERADMIN'))
                        <a class="rounded px-3 py-2 m-1 shadow-lg bg-blue-600 border-blue-700"
                            href="{{ route('users.create') }}" role="button">
                            <i class="fa fa-plus"></i></a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="flex flex-col items-center">
            <data-table :fetch-url="'{{ route('users.table') }}'"
                :columns="[{'name': 'name', 'title': 'Name'}, {'name': 'roleList', 'title': 'Roles'}]"
                :base-url="'{{ url('users') }}'" :show-action="@json(Auth::user()->hasRole('SUPERADMIN'))"
                :delete-modal-message="'Delete this user?'">
            </data-table>

            <!-- For Default pagination user -->
            {{-- <div>{{ $users->links() }}</div> --}}

            <!-- For Custom pagination User -->
            <div>{{ $users->links('components.pagination') }}</div>
        </div>
    </div>
@endsection
