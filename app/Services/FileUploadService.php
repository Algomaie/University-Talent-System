<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    protected $blockedExtensions = [
        'php', 'php3', 'php4', 'php5', 'phtml', 'exe', 'sh', 'bat', 'cmd', 'ps1', 'js', 'jsp', 'cgi', 'pl', 'py'
    ];

    public function upload(UploadedFile $file, string $path = 'uploads'): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Strict security check
        if (in_array($extension, $this->blockedExtensions)) {
            throw new \Exception('File type not allowed for security reasons.');
        }

        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $extension;
        
        // Store file
        $filePath = $file->storeAs($path, $filename, 'public');
        
        return $filePath;
    }

    public function uploadMultiple(array $files, string $path = 'uploads'): array
    {
        $uploadedFiles = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedFiles[] = $this->upload($file, $path);
            }
        }
        
        return $uploadedFiles;
    }

    public function delete(string $filePath): bool
    {
        return Storage::disk('public')->delete($filePath);
    }

    public function deleteMultiple(array $filePaths): bool
    {
        return Storage::disk('public')->delete($filePaths);
    }

    public function getFileUrl(string $filePath): string
    {
        return Storage::disk('public')->url($filePath);
    }

    public function fileExists(string $filePath): bool
    {
        return Storage::disk('public')->exists($filePath);
    }
}