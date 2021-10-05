@extends('layouts.app')

@section('content')
    <user-form :data="{{ $user }}" :roles='@json($roles)' :base-url="'{{ url('users') }}'">
    </user-form>
@endsection
