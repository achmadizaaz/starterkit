<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\Role;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function users(Request $request): View|Response
    {
        $filters = $this->validateUserFilters($request);
        $query = $this->userReportQuery($filters);
        $format = $request->input('format', 'html');

        if (in_array($format, ['pdf', 'excel'], true)) {
            abort_unless($request->user()?->can('export-user-report'), 403);
        }

        if ($format === 'pdf') {
            ActivityLogger::log('Membuka laporan user format PDF');

            return response()->view('reports.users-pdf', [
                'users' => $query->get(),
                'roles' => Role::orderBy('name')->get(),
                'filters' => $filters,
            ]);
        }

        if ($format === 'excel') {
            ActivityLogger::log('Mengunduh laporan user format Excel');

            return $this->excelResponse('laporan-user-'.now()->format('Ymd-His').'.xls', 'reports.users-excel', [
                'users' => $query->get(),
                'filters' => $filters,
            ]);
        }

        return view('reports.users', [
            'users' => $query->paginate(15)->withQueryString(),
            'roles' => Role::orderBy('name')->get(),
            'filters' => $filters,
        ]);
    }

    public function loginActivities(Request $request): View|Response
    {
        $filters = $this->validateLoginActivityFilters($request);
        $query = $this->loginActivityReportQuery($filters);
        $format = $request->input('format', 'html');

        if (in_array($format, ['pdf', 'excel'], true)) {
            abort_unless($request->user()?->can('export-login-activity-report'), 403);
        }

        if ($format === 'pdf') {
            ActivityLogger::log('Membuka laporan aktivitas login/logout format PDF');

            return response()->view('reports.login-activities-pdf', [
                'activities' => $query->get(),
                'filters' => $filters,
            ]);
        }

        if ($format === 'excel') {
            ActivityLogger::log('Mengunduh laporan aktivitas login/logout format Excel');

            return $this->excelResponse('laporan-aktivitas-login-'.now()->format('Ymd-His').'.xls', 'reports.login-activities-excel', [
                'activities' => $query->get(),
                'filters' => $filters,
            ]);
        }

        return view('reports.login-activities', [
            'activities' => $query->paginate(15)->withQueryString(),
            'filters' => $filters,
        ]);
    }

    private function validateUserFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:active,inactive'],
            'role' => ['nullable', 'exists:roles,id'],
            'email_verified' => ['nullable', 'in:verified,unverified'],
            'registered_from' => ['nullable', 'date'],
            'registered_to' => ['nullable', 'date', 'after_or_equal:registered_from'],
            'format' => ['nullable', 'in:html,pdf,excel'],
        ]);
    }

    private function validateLoginActivityFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'activity' => ['nullable', 'in:login,logout,online'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'format' => ['nullable', 'in:html,pdf,excel'],
        ]);
    }

    private function userReportQuery(array $filters): Builder
    {
        return User::with('roles')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('username', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                });
            })
            ->when(($filters['status'] ?? null) === 'active', fn ($query) => $query->where('status', true))
            ->when(($filters['status'] ?? null) === 'inactive', fn ($query) => $query->where('status', false))
            ->when($filters['role'] ?? null, fn ($query, string $roleId) => $query->whereHas('roles', fn ($query) => $query->where('roles.id', $roleId)))
            ->when(($filters['email_verified'] ?? null) === 'verified', fn ($query) => $query->whereNotNull('email_verified_at'))
            ->when(($filters['email_verified'] ?? null) === 'unverified', fn ($query) => $query->whereNull('email_verified_at'))
            ->when($filters['registered_from'] ?? null, fn ($query, string $date) => $query->whereDate('created_at', '>=', $date))
            ->when($filters['registered_to'] ?? null, fn ($query, string $date) => $query->whereDate('created_at', '<=', $date))
            ->latest();
    }

    private function loginActivityReportQuery(array $filters): Builder
    {
        return LoginHistory::with('user.roles')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('ip_address', 'like', '%'.$search.'%')
                        ->orWhere('device', 'like', '%'.$search.'%')
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', '%'.$search.'%')
                                ->orWhere('username', 'like', '%'.$search.'%')
                                ->orWhere('email', 'like', '%'.$search.'%');
                        });
                });
            })
            ->when(($filters['activity'] ?? null) === 'logout', fn ($query) => $query->whereNotNull('logout_at'))
            ->when(($filters['activity'] ?? null) === 'online', fn ($query) => $query->whereNull('logout_at'))
            ->when($filters['date_from'] ?? null, fn ($query, string $date) => $query->whereDate('login_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, string $date) => $query->whereDate('login_at', '<=', $date))
            ->latest('login_at');
    }

    private function excelResponse(string $filename, string $view, array $data): Response
    {
        return response((string) view($view, $data), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
