<?php


namespace OnzaMe\Images;


use Intervention\Image\Facades\Image;

class ImageWatermark
{
    public function add(string $imagePath, string $watermarkPath = null)
    {
        $waterMarkPath = $watermarkPath ?? $this->getDefaultWatermarkPath();
        $image = Image::make($imagePath);
        $image->insert($waterMarkPath, 'bottom-right', 5, 5);
        $image->save($imagePath);
    }

    public function getDefaultWatermarkPath()
    {
        return realpath(__DIR__.'/../resources/optimized_images').'/watermark.png';
    }
}
