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
         // Get Nama File besertan ekstensi file
        $filenameWithExt = $file->getClientOriginalName();
         // Get Nama File tanpa ekstensi file
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
         // Get Ekstensi File
        $extension = $file->getClientOriginalExtension();
         // Filename To store
        $fileNameToStore = strtolower(Str::ulid().'-'. Str::random(8)) . '.' . $extension;;
         // Upload file dan simpan ke direktori tertentu
        $filePath = $file->storeAs($directory, $fileNameToStore, $disk);
        
        return $filePath;
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