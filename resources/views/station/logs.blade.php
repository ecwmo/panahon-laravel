@extends('layouts.app')

@section('content')
    <div class="w-max flex flex-col space-y-2 items-center mx-auto">
        <div class="w-full flex justify-between items-end p-2">
            <h2 class="text-2xl">Logs</h2>
        </div>

        <data-table class="w-full" :fetch-url="'{{ url('stations') . '/' . $id . '/data-logs' }}'"
            :columns="[{'name': 'timestamp', 'title': 'Timestamp'}, {'name': 'message', 'title': 'Message'}]"
            :base-url="'{{ url('stations') }}'" :show-id-column="false">
        </data-table>
    </div>
@endsection
