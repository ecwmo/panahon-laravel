@extends('layouts.app')

@section('content')
    <user-default :fetch-url="'{{ route('users.table') }}'" :base-url="'{{ route('users.index') }}'"
        :is-admin="@json(Auth::check() && Auth::user()->hasRole('SUPERADMIN'))">
    </user-default>
@endsection
