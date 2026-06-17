<?php

namespace App\Http\Controllers;

use App\Services\SystemHealthService;

class SystemHealthController extends Controller
{
    public function __construct(private readonly SystemHealthService $healthService)
    {
    }

    public function index()
    {
        $checks = collect($this->healthService->checks());

        return view('system-health.index', [
            'checks' => $checks,
            'overallStatus' => $checks->contains('status', 'failed')
                ? 'failed'
                : ($checks->contains('status', 'warning') ? 'warning' : 'ok'),
        ]);
    }
}
