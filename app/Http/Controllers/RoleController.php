<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Role;
// use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleRequest $request)
    {
        $roles = Role::paginate(10);
        return Inertia::render('Roles', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('RoleForm', []);
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

        return redirect()->route('roles.show', $role)->with('message', __('Role created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return Inertia::render('RoleForm', compact('role'));
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

        return redirect()->route('roles.show', $role)->with('message', __('Role updated successfully.'));
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

        return redirect()->route('roles.index')->with('message', __('Role deleted successfully.'));
    }
}
