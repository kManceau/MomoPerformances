<?php

namespace App\Service;

use RecursiveIteratorIterator;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class ArchiveService
{

    public function extractArchive($path)
    {
        if(explode('.', $path)[1] == 'zip'){
            $zip = new \ZipArchive();
            $zip->open($path);
            $newPath = explode('.', $path)[0];
            $folderName = explode('/', $newPath)[3];
            mkdir('upload/config/extract/' . $folderName);
            $zip->extractTo('upload/config/extract/' . $folderName . '/');
            $zip->close();
        }
    }

    public function deleteFolder($path)
    {
        if (!is_dir($path)) {
            return false;
        }
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        return rmdir($path);
    }
}