<?php
namespace OnzaMe\Images\Exceptions;

use Exception;
use Throwable;

class ImageTypePreviewSizesNotFoundException extends Exception
{
    public function __construct(string $imageType = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Preview sizes of image type: "'.$imageType.'" not found', $code, $previous);
    }
}
