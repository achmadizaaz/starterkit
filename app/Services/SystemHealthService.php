<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Throwable;

class SystemHealthService
{
    public function checks(): array
    {
        return [
            $this->database(),
            $this->cache(),
            $this->storage(),
            $this->queue(),
            $this->environment(),
        ];
    }

    private function database(): array
    {
        try {
            DB::select('select 1');

            return $this->ok('Database', 'Koneksi database aktif.');
        } catch (Throwable $exception) {
            return $this->fail('Database', $exception->getMessage());
        }
    }

    private function cache(): array
    {
        try {
            Cache::put('health-check', now()->timestamp, 60);

            return Cache::has('health-check')
                ? $this->ok('Cache', 'Cache dapat ditulis dan dibaca.')
                : $this->warn('Cache', 'Cache write/read tidak mengembalikan nilai.');
        } catch (Throwable $exception) {
            return $this->fail('Cache', $exception->getMessage());
        }
    }

    private function storage(): array
    {
        $paths = [storage_path('app'), storage_path('logs'), storage_path('framework')];
        $blocked = collect($paths)->reject(fn ($path) => File::isWritable($path));

        return $blocked->isEmpty()
            ? $this->ok('Storage', 'Direktori storage utama writable.')
            : $this->fail('Storage', 'Tidak writable: '.$blocked->implode(', '));
    }

    private function queue(): array
    {
        $connection = config('queue.default');

        return $this->ok('Queue', 'Queue connection: '.$connection.'. Pastikan worker berjalan untuk job asynchronous.');
    }

    private function environment(): array
    {
        return config('app.debug')
            ? $this->warn('Environment', 'APP_DEBUG aktif. Nonaktifkan di production.')
            : $this->ok('Environment', 'APP_DEBUG nonaktif.');
    }

    private function ok(string $name, string $message): array
    {
        return ['name' => $name, 'status' => 'ok', 'message' => $message];
    }

    private function warn(string $name, string $message): array
    {
        return ['name' => $name, 'status' => 'warning', 'message' => $message];
    }

    private function fail(string $name, string $message): array
    {
        return ['name' => $name, 'status' => 'failed', 'message' => $message];
    }
}
