@extends('layouts.app')

@section('content')
    <role-form :data="{{ $role }}" :base-url="'{{ url('roles') }}'">
    </role-form>
@endsection
