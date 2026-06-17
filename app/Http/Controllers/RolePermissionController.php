<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogger;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $selectedRole = null;
        $groupedPermissions = [];

        return view('role-permission.index', [
            'roles' => $roles,
            'selectedRole' => $selectedRole,
            'groupedPermissions' => $groupedPermissions,
        ]);
    }

    public function show($roleId)
    {
        $selectedRole = Role::findOrFail($roleId);
        $roles = Role::all();

        // Ambil semua permission groups dengan sort order
        $permissionGroups = \App\Models\PermissionGroup::orderBy('sort_at')->get();

        // Kelompokkan permissions berdasarkan permission_group_id
        $groupedPermissions = [];
        foreach ($permissionGroups as $group) {
            $permissions = Permission::where('permission_group_id', $group->id)->get();

            if ($permissions->isNotEmpty()) {
                $groupedPermissions[$group->id] = [
                    'id' => $group->id,
                    'name' => $group->name,
                    'sort_at' => $group->sort_at,
                    'permissions' => [],
                ];

                foreach ($permissions as $permission) {
                    // Ekstrak action dari permission name (misal: read-user -> read)
                    $parts = explode('-', $permission->name);
                    $action = $parts[0]; // Ambil bagian pertama sebagai action

                    $groupedPermissions[$group->id]['permissions'][] = [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'action' => $action,
                        'hasPermission' => $selectedRole->hasPermissionTo($permission->name),
                    ];
                }

                // Sort permissions dalam setiap group
                usort($groupedPermissions[$group->id]['permissions'], function($a, $b) {
                    $actionOrder = ['read' => 1, 'create' => 2, 'update' => 3, 'delete' => 4];
                    $orderA = $actionOrder[$a['action']] ?? 999;
                    $orderB = $actionOrder[$b['action']] ?? 999;
                    return $orderA - $orderB;
                });
            }
        }

        return view('role-permission.index', [
            'roles' => $roles,
            'selectedRole' => $selectedRole,
            'groupedPermissions' => $groupedPermissions,
        ]);
    }

    public function update(Request $request, $roleId)
    {
        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'distinct', 'exists:permissions,id'],
        ]);

        $role = Role::findOrFail($roleId);

        if ($role->code === 'super-administrator') {
            throw ValidationException::withMessages([
                'role' => 'Permission Super Administrator tidak dapat diubah.',
            ]);
        }

        $permissions = Permission::whereIn('id', $validated['permissions'] ?? [])->get();
        $role->syncPermissions($permissions);
        ActivityLogger::log('Memperbarui permission untuk role '.$role->name);

        return back()->with('success', 'Permission role telah diperbarui!');
    }
}
