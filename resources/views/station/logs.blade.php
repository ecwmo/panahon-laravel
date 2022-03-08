@extends('layouts.app')

@section('content')
    <station-logs class="w-full" :fetch-url="'{{ url('stations') . '/' . $id . '/data-logs' }}'"
        :base-url="'{{ url('stations') }}'">
    </station-logs>
@endsection
