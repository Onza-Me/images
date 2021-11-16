<?php

namespace OnzaMe\Images\Exceptions;

use Exception;
use Throwable;

class RequestImageNotFound extends Exception
{
    public function __construct(string $field = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Image not found in : "'.$field.'" field', $code, $previous);
    }
}
