<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    /**
     * @param Request $request
     * @param string $disk
     * @param string $directory
     * @param $file_name
     * @return $this|false|string
     */
    public function verifyAndUploadFile(UploadedFile $file, string $file_name = '', string $disk = 'local', string $directory = ''): string
    {
        if ($disk == 'public') {
            $path = public_path('storage/' . $directory . '/' . $file_name);
        } else {
            $path = Storage::path($directory . '/' . $file_name);
        }

        if (File::exists($path)) {
            File::delete($path);
        }
        $file_path = Storage::disk($disk)->put($directory, $file);
        $folders = explode('/', $file_path);
        $file_name = end($folders);
        return $file_name;
    }

    /**
     * delete a file
     * @param string $file_name
     * @param string $directory
     * @param string $disk
     * @return bool
     */
    public static function deleteFile(string $file_name, string $directory = '', string $disk = 'local'): bool
    {
        if ($disk == 'public') {
            $path = public_path('storage/' . $directory . '/' . $file_name);
        } else {
            $path = Storage::path($directory . '/' . $file_name);
        }

        if (File::exists($path)) {
            File::delete($path);
            return true;
        }

        return false;
    }
}
