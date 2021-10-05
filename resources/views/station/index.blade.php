@extends('layouts.app')

@section('content')
    <div class="w-max flex flex-col space-y-2 items-center mx-auto">
        <div class="w-full flex justify-between items-end p-2">
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

        <data-table class="w-full" :fetch-url="'{{ route('stations.table') }}'"
            :columns="[{'name': 'name', 'title': 'Name'}, {'name': 'address', 'title': 'Address'}, {'name': 'station_type', 'title': 'Type'}, {'name': 'status', 'title': 'Status'}, {'name': 'date_installed', 'title': 'Install Date'}]"
            :base-url="'{{ url('stations') }}'" :show-action="@json(Auth::user()->hasRole('ADMIN'))"
            :delete-modal-message="'Delete this station?'">
        </data-table>
    </div>
@endsection
