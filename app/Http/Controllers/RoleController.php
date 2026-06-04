<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::with([
            'permissions' => fn ($query) => $query
                ->with('permissionGroup')
                ->orderBy('permission_group_id')
                ->orderBy('name'),
        ])->paginate(10);

        return view('role.index', [
            'roles' => $roles,
        ]);
    }

    public function store(CreateRoleRequest $request)
    {
        Role::create([
            'code' => $request->code,
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return back()->with('success', 'Role telah ditambahkan!');
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->code === 'super-administrator' && (
            $request->code !== 'super-administrator'
            || $request->name !== 'Super Administrator'
        )) {
            throw ValidationException::withMessages([
                'code' => 'Role Super Administrator tidak dapat diubah.',
            ]);
        }

        $role->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return back()->with('success', 'Role telah diperbarui!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->code === 'super-administrator') {
            throw ValidationException::withMessages([
                'role' => 'Role Super Administrator tidak dapat dihapus.',
            ]);
        }

        $role->delete();

        return back()->with('success', 'Role telah dihapus!');
    }
}
