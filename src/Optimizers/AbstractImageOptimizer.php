<?php

namespace OnzaMe\Images\Optimizers;

use Kraken;
use OnzaMe\Images\Contracts\ImageOptimizerContract;
use OnzaMe\Images\FileUploadService;

abstract class AbstractImageOptimizer implements ImageOptimizerContract
{
    /**
     * @param string $image URL or file path
     * @param string $saveTo
     * @return bool
     */
    abstract public function optimize(string $image, string $saveTo): bool;

    public function saveOptimizedImage(string $optimizedUrl, string $saveTo): bool
    {
        try {
            (new FileUploadService)->downloadFile($optimizedUrl, $saveTo);
        } catch (\Exception $exception) {
            if (function_exists('logs')) {
                logs()->error($exception->getMessage());
            }
            return false;
        }
        return true;
    }
}
