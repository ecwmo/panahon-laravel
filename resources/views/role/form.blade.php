@extends('layouts.app')

@section('content')
<div class="container" x-data="roleForm({{ $role }})">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header fs-2">{{ $role->id ? "Update ".$role->name : "Add new role" }}</div>
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success text-center">
                            {{Session::get('success')}}
                        </div>
                    @endif

                    <form method="post"
                        action="{{ $role->id == null ? url('roles') :  url('roles/'.$role->id)}}"
                        >
                        @isset($role->id)
                        {{ method_field('PATCH')}}
                        @endisset
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="text"
                                class="form-control text-uppercase @error('name') is-invalid @enderror"
                                placeholder="Role Name" name="name"
                                value="{{ old('name', $role->name) }}"
                                required/>
                            <label for="name">Role Name</label>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text"
                                class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" placeholder="Description"
                                value="{{ old('description', $role->description) }}" />
                            <label for="description">Description</label>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ $role->id ? "Update" : "Add" }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
