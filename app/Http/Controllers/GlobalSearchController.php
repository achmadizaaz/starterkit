<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $query = Str::of($validated['q'])->trim()->lower()->toString();
        $results = $this->menuResults($request, $query);

        if ($request->user()->can('read-user')) {
            $users = User::query()
                ->select(['id', 'name', 'username', 'email', 'status'])
                ->where(function ($builder) use ($query) {
                    $builder->where('name', 'like', '%'.$query.'%')
                        ->orWhere('username', 'like', '%'.$query.'%')
                        ->orWhere('email', 'like', '%'.$query.'%');
                })
                ->orderByDesc('status')
                ->orderBy('name')
                ->limit(6)
                ->get()
                ->map(fn (User $user) => [
                    'type' => 'user',
                    'title' => $user->name,
                    'description' => '@'.$user->username.' · '.$user->email,
                    'url' => route('user.show', $user->username),
                    'icon' => 'bi-person',
                    'badge' => $user->status ? 'Active' : 'Inactive',
                ]);

            $results = $results->concat($users);
        }

        return response()->json([
            'results' => $results->take(10)->values(),
        ]);
    }

    private function menuResults(Request $request, string $query): Collection
    {
        $items = collect([
            ['title' => 'Dashboard', 'description' => 'Ringkasan aplikasi', 'route' => 'dashboard', 'icon' => 'bi-grid-1x2', 'permission' => null],
            ['title' => 'Users', 'description' => 'Kelola data pengguna', 'route' => 'user.index', 'icon' => 'bi-people', 'permission' => 'read-user'],
            ['title' => 'Roles', 'description' => 'Kelola role pengguna', 'route' => 'role.index', 'icon' => 'bi-shield-check', 'permission' => 'read-role'],
            ['title' => 'Permission List', 'description' => 'Daftar permission aplikasi', 'route' => 'permission.index', 'icon' => 'bi-key', 'permission' => 'read-permission'],
            ['title' => 'Permission Groups', 'description' => 'Kelola grup permission', 'route' => 'permission-group.index', 'icon' => 'bi-collection', 'permission' => 'read-permission-group'],
            ['title' => 'Assign Permission', 'description' => 'Atur permission role', 'route' => 'role-permission.index', 'icon' => 'bi-shield-lock', 'permission' => 'read-role-permission'],
            ['title' => 'Audit Log', 'description' => 'Riwayat aktivitas sistem', 'route' => 'audit-log.index', 'icon' => 'bi-journal-text', 'permission' => 'read-activity-log'],
            ['title' => 'Backup Database', 'description' => 'Backup dan restore database', 'route' => 'backup.index', 'icon' => 'bi-database', 'permission' => 'read-backup-database'],
            ['title' => 'System Health', 'description' => 'Status layanan aplikasi', 'route' => 'system-health.index', 'icon' => 'bi-activity', 'permission' => 'read-system-health'],
            ['title' => 'Notifikasi Admin', 'description' => 'Pusat notifikasi administrator', 'route' => 'notifications.index', 'icon' => 'bi-bell', 'permission' => 'read-notification'],
            ['title' => 'Laporan User', 'description' => 'Laporan data pengguna', 'route' => 'reports.users', 'icon' => 'bi-file-earmark-person', 'permission' => 'read-user-report'],
            ['title' => 'Aktivitas Login / Logout', 'description' => 'Laporan akses pengguna', 'route' => 'reports.login-activities', 'icon' => 'bi-clock-history', 'permission' => 'read-login-activity-report'],
            ['title' => 'Pengaturan', 'description' => 'Pengaturan umum aplikasi', 'route' => 'settings.index', 'icon' => 'bi-gear', 'permission' => 'read-settings'],
            ['title' => 'Profile', 'description' => 'Profil dan keamanan akun', 'route' => 'profile.show', 'icon' => 'bi-person-circle', 'permission' => null],
        ]);

        return $items
            ->filter(fn (array $item) => ! $item['permission'] || $request->user()->can($item['permission']))
            ->filter(function (array $item) use ($query) {
                return Str::contains(Str::lower($item['title'].' '.$item['description']), $query);
            })
            ->map(fn (array $item) => [
                'type' => 'menu',
                'title' => $item['title'],
                'description' => $item['description'],
                'url' => route($item['route']),
                'icon' => $item['icon'],
                'badge' => 'Menu',
            ]);
    }
}
