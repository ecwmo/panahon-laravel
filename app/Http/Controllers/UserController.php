<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::paginate(10);

        foreach ($users as $user) {
            $user->roleList = $user->roles->pluck('name')->implode(', ');
        }
        return Inertia::render('Users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return $this->show($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->storeOrUpdate($request);
        return redirect()->route('users.show', $user)->with('message', __('User created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (isset($user['id'])) {
            $user->roleIds = $user->roles->pluck('id');
        }
        return Inertia::render('UserForm', [
            'user' => $user,
            'roles' => Role::all()
          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = $this->storeOrUpdate($request, $user);
        return redirect()->route('users.show', $user)->with('message', __('User updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('message', __('User deleted successfully.'));
    }

    /**
   * Store or Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \App\Models\User  $user
   */
    private function storeOrUpdate(Request $request, User $user = null)
    {
        $emailValidator = 'required|string|max:255|unique:users,email';
        if ($user) {
            $emailValidator = $emailValidator . ',' . $user->id;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => $emailValidator,
            'password' => 'nullable|string|min:8'
        ]);

        if (!$user) {
            $user = User::create($validated);
            $user->roles()->attach($request->roleIds);
        } else {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email']
            ]);

            if (isset($validated['password'])) {
                $user->password = Hash::make($validated['password']);
                $user->save();
            }

            $user->roles()->sync($request->roleIds);
        }

        return $user;
    }
}
