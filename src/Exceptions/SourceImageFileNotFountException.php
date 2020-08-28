<?php
namespace OnzaMe\Images\Exceptions;

use Exception;
use Throwable;

class SourceImageFileNotFountException extends Exception
{
    public function __construct(string $filepath = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Source image file: "'.$filepath.'" not found', $code, $previous);
    }
}
