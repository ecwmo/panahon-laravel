@extends('layouts.app')

@section('content')
    <role-default :base-url="'{{ route('roles.index') }}'" :show-create-btn="@json(Auth::check() && Auth::user()->hasRole('SUPERADMIN'))">
    </role-default>
@endsection
