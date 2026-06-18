<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\DatabaseBackup;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\DatabaseBackupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseBackupController extends Controller
{
    public function __construct(private readonly DatabaseBackupService $backupService)
    {
    }

    public function index()
    {
        return view('backup.index', [
            'backups' => DatabaseBackup::with(['user', 'restoredBy'])->latest()->paginate(10),
            'retentionDays' => AppSetting::getValue('backup_retention_days', '7'),
        ]);
    }

    public function store(): RedirectResponse
    {
        $backup = $this->backupService->create();
        ActivityLogger::log('Membuat backup database '.$backup->filename);

        return back()->with('success', 'Backup database terenkripsi berhasil dibuat.');
    }

    public function updatePolicy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'backup_retention_days' => ['required', 'integer', 'min:1', 'max:365'],
        ]);

        AppSetting::setValue('backup_retention_days', (string) $validated['backup_retention_days']);
        ActivityLogger::log('Memperbarui kebijakan retensi backup database');

        return back()->with('success', 'Kebijakan backup berhasil diperbarui.');
    }

    public function download(DatabaseBackup $backup): StreamedResponse
    {
        ActivityLogger::log('Mengunduh backup database '.$backup->filename);
        $content = $this->backupService->decryptedContent($backup);
        $filename = str($backup->filename)->replaceLast('.enc', '')->toString();

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename, [
            'Content-Type' => 'application/sql; charset=UTF-8',
        ]);
    }

    public function destroy(DatabaseBackup $backup): RedirectResponse
    {
        $filename = $backup->filename;
        $this->backupService->delete($backup);
        ActivityLogger::log('Menghapus backup database '.$filename);

        return back()->with('success', 'Backup database berhasil dihapus.');
    }

    public function dryRun(DatabaseBackup $backup): RedirectResponse
    {
        $this->ensureSuperAdministrator();

        $inspection = $this->backupService->inspect($backup);

        if (! $inspection['valid']) {
            throw ValidationException::withMessages([
                'backup' => 'Format backup tidak valid untuk aplikasi ini.',
            ]);
        }

        ActivityLogger::log('Melakukan dry-run restore backup '.$backup->filename);

        return back()->with('restore_inspection', $inspection);
    }

    public function restore(Request $request, DatabaseBackup $backup): RedirectResponse
    {
        $this->ensureSuperAdministrator();

        $validated = $request->validate([
            'confirmation' => ['required', 'string'],
        ]);

        $expected = 'RESTORE '.$backup->filename;

        if ($validated['confirmation'] !== $expected) {
            throw ValidationException::withMessages([
                'confirmation' => 'Konfirmasi tidak sesuai. Ketik persis: '.$expected,
            ]);
        }

        $restoredBy = $request->user()->id;
        $inspection = $this->backupService->restore($backup);
        $backup->forceFill([
            'restored_at' => now(),
            'restored_by' => User::whereKey($restoredBy)->exists() ? $restoredBy : null,
        ])->save();
        ActivityLogger::log('Melakukan restore database dari backup '.$backup->filename);

        return back()->with('success', 'Restore database berhasil dijalankan. '.$inspection['statements'].' statement diproses.');
    }

    private function ensureSuperAdministrator(): void
    {
        abort_unless(request()->user()?->hasRole('Super Administrator'), 403);
    }
}
