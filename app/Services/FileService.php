<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
     /**
     * Upload file ke disk yang diinginkan
     *
     * @param object $file['image|file']
     * @param string $directory
     * @param string|null $disk (default: Private)
     * @return string $filePath
     */
    public function upload(object $file, string $directory, ?string $disk = 'local'): string
    {
        $extension = $file->extension();
        $fileNameToStore = strtolower(Str::ulid().'-'.Str::random(8)).'.'.$extension;

        return $file->storeAs($directory, $fileNameToStore, $disk);
    }

    /**
     * Mendownload file dari disk
     *
     * @param string $filePath
     * @param string|null $disk
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(string $filePath, ?string $disk = 'local', string $customName = null)
    {
        if (Storage::disk($disk)->exists($filePath)) {
            if(!is_null($customName)){
                // Get path fisik  file
                $file = Storage::disk($disk)->path($filePath);
                // Gunakan response()->download() untuk mengubah nama file saat diunduh
                return response()->download($file, $customName);
            }

            return Storage::disk($disk)->download($filePath);
        }

        throw new \Exception('File not found.');
    }

    /**
     * Menghapus file dari disk
     *
     * @param string $filePath
     * @param string|null $disk
     * @return bool
     */
    public function delete(string $filePath, ?string $disk = 'local'): bool
    {
        return Storage::disk($disk)->delete($filePath);
    }
}
