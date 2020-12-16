<?php


namespace OnzaMe\Images\Contracts;


use OnzaMe\Images\FileUploadService;

interface ImageOptimizerContract
{
    /**
     * @param string $image URL or file path
     * @param string $saveTo
     * @return bool
     */
    public function optimize(string $image, string $saveTo): bool;

    public function saveOptimizedImage(string $optimizedUrl, string $saveTo): bool;
}
