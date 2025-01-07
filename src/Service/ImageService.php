<?php

namespace App\Service;

use phpDocumentor\Reflection\Types\Boolean;

class ImageService
{
    public function createImages($image, $folder):\GdImage
    {
        $image = imagecreatefromstring(file_get_contents($image));
        return $this->resizeImage($image, $folder);
    }

    public function resizeImage($image, $folder){
        $originalWidth = ImageSX($image);
        $originalHeight = ImageSY($image);
        $maxWidth = match ($folder) {
            'avatar' => 400,
            default => $originalWidth,
        };
        if ($originalWidth > $maxWidth) {
            $ratio = $maxWidth / $originalWidth;
            $maxHeight = $originalHeight * $ratio;
        } else {
            $maxWidth = $originalWidth;
            $maxHeight = $originalHeight;
        }
        imagepalettetotruecolor($image);
        $resizedImage = imagecreatetruecolor($maxWidth, $maxHeight);
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $maxWidth, $maxHeight, $originalWidth, $originalHeight);
        imagedestroy($image);
        return $resizedImage;
    }

    public function uploadImages($img, $id, $folder):void
    {
        $image = $this->createImages($img, $folder);
        if($folder == 'team' || $folder == 'partners'){
            imagepng($image, 'upload/'.$folder.'/'.$id.'.png', 10,  PNG_ALL_FILTERS);
        } else {
            imagejpeg($image, 'upload/'.$folder.'/'.$id.'.jpg', 100);
        }
        imagewebp($image, 'upload/'.$folder.'/'.$id.'.webp', 100);
        imagedestroy($image);
    }

    public function deleteImages($id, $folder):void
    {
        if(file_exists('upload/'.$folder.'/'.$id.'.png')){
            unlink('upload/'.$folder.'/'.$id.'.png');
        }
        if(file_exists('upload/'.$folder.'/'.$id.'.jpg')){
            unlink('upload/'.$folder.'/'.$id.'.jpg');
        }
        if(file_exists('upload/'.$folder.'/'.$id.'.webp')){
            unlink('upload/'.$folder.'/'.$id.'.webp');
        }
    }

    public function listImages():array
    {
        $scan = scandir('upload/pages/');
        array_shift($scan);
        array_shift($scan);
        $images = [];
        foreach ($scan as $file) {
            if(str_contains($file, '.webp')){
                array_push($images, $file);
            }
        }
        return $images;
    }
}

