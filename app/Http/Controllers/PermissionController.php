<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

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
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'permission_group_id' => $request->permission_group_id,
        ]);
        ActivityLogger::log('Menambahkan permission '.$permission->name);

        return back()->with('success', 'Permission telah ditambahkan!');
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => $request->name,
            'permission_group_id' => $request->permission_group_id,
        ]);
        ActivityLogger::log('Memperbarui permission '.$permission->name);

        return back()->with('success', 'Permission telah diperbarui!');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permissionName = $permission->name;
        $permission->delete();
        ActivityLogger::log('Menghapus permission '.$permissionName);

        return back()->with('success', 'Permission telah dihapus!');
    }
}
