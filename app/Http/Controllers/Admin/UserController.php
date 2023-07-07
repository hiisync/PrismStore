<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:see users')->only('index', 'show');
        $this->middleware('permission:edit users')->only('edit', 'update');
        $this->middleware('permission:delete users')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::with('roles')
                ->when($request->input('search'), function ($query, $search) {
                    return $query->where('name', 'like', '%'.$search.'%');
                })
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        $orders = $user->orders()->with('product')->latest()->paginate(10);
        $payments = $user->payments()->latest()->paginate(10);

        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
            'orders' => $orders->withQueryString(),
            'payments' => $payments->withQueryString(),
            'lang' => session('locale'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Admin/Users/Edit', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'user' => $user->load('roles', 'permissions'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        // update user's data
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'balance' => $request->input('balance'),
        ]);

        // update user's roles
        $user->syncRoles($request->input('roles'));
        $user->syncPermissions($request->input('permissions'));

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
