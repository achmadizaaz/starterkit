<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        return view('permission.index', [
            'permissions' => Permission::with('permissionGroup')->paginate(10),
            'permissionGroups' => PermissionGroup::orderBy('sort_at')->get(),
        ]);
    }

    public function store(CreatePermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'permission_group_id' => $request->permission_group_id,
        ]);

        return back()->with('success', 'Permission telah ditambahkan!');
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => $request->name,
            'permission_group_id' => $request->permission_group_id,
        ]);

        return back()->with('success', 'Permission telah diperbarui!');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return back()->with('success', 'Permission telah dihapus!');
    }
}
