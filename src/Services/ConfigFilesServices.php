<?php

namespace App\Services;

class ConfigFilesServices
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
    public function getFile($id)
    {
        $fileList = scandir('upload/config/zip');
        $fileList = array_slice($fileList, 2);
        $result = false;
        foreach ($fileList as $file) {
            $fileId = explode('_', $file)[0];
            if ($fileId == $id) {
                $result = explode('.', $file)[0];
            }
        }
        return $result;
    }
}