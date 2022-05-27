<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
// use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleRequest $request)
    {
        if ($request->has('all')) {
            return Role::all();
        }
        return Role::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $request->validate([
            'name' => 'required|max:200|unique:roles,name',
            'description' => 'max:255|nullable',
        ]);

        $role = Role::create($request->all());

        return $role;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $role;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:200|unique:roles,name,' . $role->id,
            'description' => 'max:255|nullable',
        ]);

        $role->update($request->all());

        return $role;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $role;
    }
}
