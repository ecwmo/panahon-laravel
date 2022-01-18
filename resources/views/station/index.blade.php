@extends('layouts.app')

@section('content')
    <station-default :fetch-url="'{{ route('stations.table') }}'" :base-url="'{{ route('stations.index') }}'"
        :is-admin="@json(Auth::check() && Auth::user()->hasRole('ADMIN'))">
    </station-default>
@endsection
