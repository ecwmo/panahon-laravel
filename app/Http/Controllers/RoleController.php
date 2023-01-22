<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Role;
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
        $role = new Role();
        return $this->show($role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = $this->storeOrUpdate($request);
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
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role = $this->storeOrUpdate($request, $role);
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

    /**
   * Store or Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\RoleRequest  $request
   * @param  \App\Models\Role  $role
   * @return \App\Models\Role  $role
   */
    private function storeOrUpdate(RoleRequest $request, Role $role = null)
    {
        $nameValidator = 'required|max:200|unique:roles,name';
        if ($role) {
            $nameValidator = $nameValidator . ',' . $role->id;
        }

        $validated = $request->validate([
            'name' => $nameValidator,
            'description' => 'max:255|nullable',
        ]);

        if (!$role) {
            $role = Role::create($validated);
        } else {
            $role->update($validated);
        }

        return $role;
    }
}
