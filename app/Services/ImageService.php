<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    public function optimizeImage($image, $cropWidth = 70, $cropHeight = 70, $extension = 'jpg'): string
    {
        $source = Image::read($image->getPathname());

        $source->cover($cropWidth, $cropHeight);
        $fileName = time() . '_' . md5($image->getClientOriginalName()) . '.' . $extension;;
        $source->save(public_path('assets/images/' . $fileName));

        return '/assets/images/' . $fileName;
    }
}
