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
     * Generate all previews and get urls to them. Return structure: ['preview_name' => 'file path']
     *
     * @param string $imagepath
     * @param string $imageType
     * @param int $quality
     * @return array Array of strings
     */
    public function generatePreviews(string $imagepath, string $imageType = 'default', int $quality = 100): array
    {
        $imageResize = new ImageResize();
        $sizes = $imageResize->getPreviewSizes($imageType);
        $generatedPreviews = [];
        foreach ($sizes as $sizeName => $size) {
            ['width' => $width, 'height' => $height] = $size;
            $generatedPreviews[$sizeName] = $imageResize->resize($imagepath, $width, $height, $quality);
        }
        return $generatedPreviews;
    }

    /**
     * Generate preview and get url to generated preview file.
     *
     * @param string $imagepath
     * @param string $imageType
     * @param string $specificPreviewName
     * @param int $quality
     * @return string Preview image file path
     */
    public function generatePreview(string $imagepath, string $imageType = 'default', string $specificPreviewName = 'default', int $quality = 100): string
    {
        $imageResize = new ImageResize();

        [$width, $height] = $imageResize->getPreviewSize($imageType, $specificPreviewName);

        return $imageResize->resize($imagepath, $width, $height, $quality);
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
