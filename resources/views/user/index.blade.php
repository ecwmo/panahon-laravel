@extends('layouts.app')

@section('content')
    <user-default :fetch-url="'{{ route('users.table') }}'" :base-url="'{{ route('users.index') }}'"
        :show-create-btn="@json(Auth::check() && Auth::user()->hasRole('SUPERADMIN'))">
    </user-default>
@endsection
