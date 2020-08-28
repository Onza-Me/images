<?php

namespace OnzaMe\Images;

use Intervention\Image\Facades\Image;

class Images
{
    /**
     * Optimize image by absolute file path
     *
     * @param string $imagepath
     * @return bool
     */
    public function optimize(string $imagepath): bool
    {
        $apiKeys = config('onzame_images.krakenio');
        return (new KrakenIO($apiKeys['api_key'], $apiKeys['api_secret']))
            ->optimize($imagepath, $imagepath);
    }

    /**
     * Get file extesion by file path
     *
     * @param string $filepath
     * @return mixed|string
     */
    private function getExt(string $filepath): string
    {
        $explodeUrl = explode('.', $filepath);
        return $explodeUrl[count($explodeUrl) - 1];
    }

    /**
     * Convert image to necessary format, Note: without deleting previous version of image file
     *
     * @param string $filepath
     * @param string $convert2fromat
     * @param bool $deleteOldFile
     * @return bool|string
     */
    public function convert(string $filepath, string $convert2fromat = 'jpg', bool $deleteOldFile = false)
    {
        if ($this->getExt($filepath) === $convert2fromat) {
            return false;
        } else if (!file_exists($filepath)) {
            logs()->warning('"'.$filepath.'"'.': file not found.');
            return false;
        }

        $newFilepath = $this->getNewFilepathForConvertedFile($filepath, $convert2fromat);
        Image::make($filepath)
            ->encode($convert2fromat)
            ->save($newFilepath);

        if ($deleteOldFile) {
            unlink($filepath);
        }

        return $newFilepath;
    }

    /**
     * @param string $filepath
     * @param string $convert2fromat
     * @return string
     */
    private function getNewFilepathForConvertedFile(string $filepath, string $convert2fromat): string
    {
        return str_replace($this->getExt($filepath), $convert2fromat, $filepath);
    }
}
