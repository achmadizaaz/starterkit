<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class UserReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $users, $role, $isActive, $orderBy;

    public function __construct($users, $role, $isActive, $orderBy)
    {
        $this->users = $users;
        $this->role = $role;
        $this->isActive = $isActive;
        $this->orderBy = $orderBy;
    }

    public function view(): View
    {
        return view('exports.user', [
            'users' => $this->users,
            'role' => $this->role,
            'isActive' => $this->isActive,
            'orderBy' => $this->orderBy,
        ]);
    }
}
