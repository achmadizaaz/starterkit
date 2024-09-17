<?php

namespace App\Http\Controllers\Report;

use App\Exports\UserReportExport;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserReportController extends Controller
{
    protected $model, $role;

    public function __construct(User $model, Role $role)
    {
        $this->model = $model;
        $this->role = $role;
    }

    public function index()
    {
        $roles = $this->role->all();
        return view('reports.user-index', compact('roles'));
    }

    public function show(Request $request)
    {
        $isActive = $request->status;
        $role = $request->role;
        $orderBy = $request->orderBy;

        $users = $this->model->with(['roles']);

        
        // Jika status is active bukan semua
        if($isActive != 'semua'){
            $users = $users->where('is_active', $isActive);

            $isActive = 1 ? 'Active' : 'Non active';
        }
        // Jika status role bukan semua
        if($role != 'semua'){
            $users = $users->whereHas('roles', function($query) use ($role){
                $query->where('id', $role);
            });

            $role = $this->role->find($role)->name;
        }

        $users = $users->orderBy('id', $orderBy)->get();

        if($request->type == 'excel'){
            return Excel::download(new UserReportExport($users, $role, $isActive, $orderBy), 'users.xlsx');
        }


        return view('reports.user-show', compact('users', 'isActive', 'role', 'orderBy'));
    }
}
