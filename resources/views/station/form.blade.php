@extends('layouts.app')

@section('content')
    <station-form :data="{{ $station }}" :base-url="'{{ url('stations') }}'">
    </station-form>
@endsection
