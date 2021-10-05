@extends('layouts.app')

@section('content')
    <div class="flex flex-col space-y-2">
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
        <div class="flex flex-col items-center">
            <station-table :data='@json($stations)' :base-url="'{{ url('stations') }}'"
                :show-action="{{ Auth::user()->hasRole('ADMIN') }}">
            </station-table>
            <!-- For Default pagination user -->
            {{-- <div>{{ $stations->links() }}</div> --}}

            <!-- For Custom pagination User -->
            <div>{{ $stations->links('components.pagination') }}</div>
        </div>
    </div>
@endsection
