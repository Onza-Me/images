<?php
namespace OnzaMe\Images;

use Intervention\Image\Facades\Image as ImageFacade;
use Intervention\Image\Image;
use OnzaMe\Images\Exceptions\SourceImageFileNotFountException;

class ImageResize
{
    /**
     * @param string $filepath
     * @param int $width
     * @param int $height
     * @param int $quality
     * @param bool $skipOptimize
     * @return string
     * @throws SourceImageFileNotFountException
     */
    public function resize(string $filepath, int $width, int $height, int $quality = 80): string
    {
        if (!file_exists($filepath)) {
            throw new SourceImageFileNotFountException($filepath);
        }

        $img = ImageFacade::make($filepath);
        $cropFilepath = $this->getResizedFilepath($filepath, $width, $height);

        $this->fitImage($img, $width, $height)
            ->resize($width, $height)
            ->save($cropFilepath, $quality);

        return $cropFilepath;
    }

    /**
     * @param Image $img
     * @param $width
     * @param $height
     * @param null $path
     * @param null $quality
     * @return mixed
     */
    private function fitImage(Image $img, int $width, int $height): Image
    {
        $img = $img->fit($width, $height, function ($constraint) {
            $constraint->upsize();
        });
        return $img;
    }

    private function getResizedFilepath(string $sourceFilepath, int $width, int $height): string
    {
        $explodedFilepath = explode('/', $sourceFilepath);
        $lastItemIndex = count($explodedFilepath) - 1;
        $filename = $explodedFilepath[$lastItemIndex];
        unset($explodedFilepath[$lastItemIndex]);
        $explodedFilepath[] = $width.'-'.$height.'-'.$filename;
        return implode('/', $explodedFilepath);
    }
}