@extends('layouts.app')

@section('content')
    <station-default :base-url="'{{ route('stations.index') }}'" :show-create-btn="@json(Auth::check() && Auth::user()->hasRole('ADMIN'))">
    </station-default>
@endsection
