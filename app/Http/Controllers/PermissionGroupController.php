<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use App\Http\Requests\PermissionGroup\CreatePermissionGroupRequest;
use App\Http\Requests\PermissionGroup\UpdatePermissionGroupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogger;

class PermissionGroupController extends Controller
{
    public function index(Request $request)
    {
        $permissionGroups = PermissionGroup::with(['permissions' => function ($query) {
            $query->select('id', 'name', 'guard_name', 'permission_group_id')->orderBy('name');
        }])->withCount('permissions')->orderBy('sort_at')->paginate(10);

        return view('permission-group.index', [
            'permissionGroups' => $permissionGroups,
            'permissionGroupsPayload' => $permissionGroups->getCollection()->mapWithKeys(function ($group) {
                return [
                    (string) $group->id => [
                        'name' => $group->name,
                        'permissions' => $group->permissions->map(function ($permission) {
                            return [
                                'name' => $permission->name,
                                'guard_name' => $permission->guard_name,
                            ];
                        })->values(),
                    ],
                ];
            }),
        ]);
    }

    public function store(CreatePermissionGroupRequest $request)
    {
        $permissionGroup = PermissionGroup::create([
            'name' => $request->name,
            'sort_at' => $request->sort_at,
        ]);
        ActivityLogger::log('Menambahkan permission group '.$permissionGroup->name);

        return back()->with('success', 'Permission Group telah ditambahkan!');
    }

    public function update(UpdatePermissionGroupRequest $request, $id)
    {
        $permissionGroup = PermissionGroup::findOrFail($id);

        $permissionGroup->update([
            'name' => $request->name,
            'sort_at' => $request->sort_at,
        ]);
        ActivityLogger::log('Memperbarui permission group '.$permissionGroup->name);

        return back()->with('success', 'Permission Group telah diperbarui!');
    }

    public function moveUp($id)
    {
        $permissionGroup = PermissionGroup::findOrFail($id);
        $targetGroup = PermissionGroup::where('sort_at', '<', $permissionGroup->sort_at)
            ->orderByDesc('sort_at')
            ->first();

        if (! $targetGroup) {
            return back()->with('info', 'Permission Group sudah berada di urutan paling atas.');
        }

        $this->swapSortOrder($permissionGroup, $targetGroup);
        ActivityLogger::log('Menaikkan urutan permission group '.$permissionGroup->name);

        return back()->with('success', 'Urutan Permission Group telah dinaikkan!');
    }

    public function moveDown($id)
    {
        $permissionGroup = PermissionGroup::findOrFail($id);
        $targetGroup = PermissionGroup::where('sort_at', '>', $permissionGroup->sort_at)
            ->orderBy('sort_at')
            ->first();

        if (! $targetGroup) {
            return back()->with('info', 'Permission Group sudah berada di urutan paling bawah.');
        }

        $this->swapSortOrder($permissionGroup, $targetGroup);
        ActivityLogger::log('Menurunkan urutan permission group '.$permissionGroup->name);

        return back()->with('success', 'Urutan Permission Group telah diturunkan!');
    }

    private function swapSortOrder(PermissionGroup $permissionGroup, PermissionGroup $targetGroup): void
    {
        DB::transaction(function () use ($permissionGroup, $targetGroup) {
            $currentSortOrder = $permissionGroup->sort_at;
            $targetSortOrder = $targetGroup->sort_at;
            $temporarySortOrder = ((int) PermissionGroup::max('sort_at')) + 1;

            $permissionGroup->update(['sort_at' => $temporarySortOrder]);
            $targetGroup->update(['sort_at' => $currentSortOrder]);
            $permissionGroup->update(['sort_at' => $targetSortOrder]);
        });
    }

    public function destroy($id)
    {
        $permissionGroup = PermissionGroup::findOrFail($id);
        $permissionGroupName = $permissionGroup->name;
        $permissionGroup->delete();
        ActivityLogger::log('Menghapus permission group '.$permissionGroupName);

        return back()->with('success', 'Permission Group telah dihapus!');
    }
}
