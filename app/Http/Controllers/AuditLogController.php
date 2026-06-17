<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'user_id', 'date_from', 'date_to']);

        return view('audit-log.index', [
            'logs' => $this->query($filters)->latest()->paginate(15)->withQueryString(),
            'users' => User::whereHas('activityLogs')->orderBy('name')->get(['id', 'name', 'email']),
            'filters' => $filters,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $logs = $this->query($request->only(['search', 'user_id', 'date_from', 'date_to']))
            ->latest()
            ->limit(5000)
            ->get();

        return response()->streamDownload(function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Waktu', 'User', 'Email', 'Aktivitas', 'IP Address', 'User Agent']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    optional($log->created_at)->format('Y-m-d H:i:s'),
                    $log->user?->name ?? '-',
                    $log->user?->email ?? '-',
                    $log->activity,
                    $log->ip_address,
                    $log->user_agent,
                ]);
            }

            fclose($handle);
        }, 'audit-log-'.now()->format('Ymd-His').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function query(array $filters): Builder
    {
        return ActivityLog::with('user')
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('activity', 'like', '%'.$search.'%')
                        ->orWhere('ip_address', 'like', '%'.$search.'%')
                        ->orWhereHas('user', function (Builder $query) use ($search) {
                            $query->where('name', 'like', '%'.$search.'%')
                                ->orWhere('email', 'like', '%'.$search.'%');
                        });
                });
            })
            ->when($filters['user_id'] ?? null, fn (Builder $query, string $userId) => $query->where('user_id', $userId))
            ->when($filters['date_from'] ?? null, fn (Builder $query, string $date) => $query->whereDate('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn (Builder $query, string $date) => $query->whereDate('created_at', '<=', $date));
    }
}
