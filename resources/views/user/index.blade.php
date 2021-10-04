@extends('layouts.app')

@section('content')
    <div class="flex flex-col space-y-2" x-data="userForm()">
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

        <div class="flex justify-center">
            <table class="space-y-6 text-sm">
                <thead>
                    <tr class="text-center">
                        <th class="p-2 border border-gray-300" scope="col">Name</th>
                        <th class="p-2 border border-gray-300" scope="col">Roles</th>
                        @auth
                            @if (Auth::user()->hasRole('SUPERADMIN'))
                                <th class="p-2 border border-gray-300" scope="col">Action</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th class="p-2 text-justify border border-gray-300" scope="row">{{ $user->name }}</th>
                            <td class="p-2 text-justify border border-gray-300">{{ $user->roleList }}</td>
                            @auth
                                @if (Auth::user()->hasRole('SUPERADMIN'))
                                    <td class="p-2 text-center border border-gray-300 space-x-2">
                                        <a title="Edit" href="{{ url('users/' . $user->id . '/edit') }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a title="Delete" @click="deleteUser({{ $user->id }})"><i
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
            {{-- <div>{{ $users->links() }}</div> --}}

            <!-- For Custom pagination User -->
            <div>{{ $users->links('components.pagination') }}</div>
        </div>

        <!-- Modal -->
        @auth
            @if (Auth::user()->hasRole('SUPERADMIN'))
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
                                    <div class="font-medium leading-none">Delete this user?</div>
                                </div>
                            </div>
                            <form x-bind:action="`{{ url('users') }}/${user.id}`" method="post">
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
