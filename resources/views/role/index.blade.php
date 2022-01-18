@extends('layouts.app')

@section('content')
    <role-default :fetch-url="'{{ route('roles.table') }}'" :base-url="'{{ route('roles.index') }}'"
        :is-admin="@json(Auth::check() && Auth::user()->hasRole('SUPERADMIN'))">
    </role-default>
@endsection
