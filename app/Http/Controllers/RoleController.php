<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        return view('role.index', [
            'roles' => Role::paginate(10)
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

        $role->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return back()->with('success', 'Role telah diperbarui!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return back()->with('success', 'Role telah dihapus!');
    }
}
