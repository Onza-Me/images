<?php
namespace OnzaMe\Images\Exceptions;

use Exception;
use Throwable;

class ImageTypePreviewSizeForSpecificPreviewNameNotFoundException extends Exception
{
    public function __construct(string $imageType = "", string $previewSpecificName = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Specific preview size: "'.$previewSpecificName.'" of image type: "'.$imageType.'" not found', $code, $previous);
    }
}
