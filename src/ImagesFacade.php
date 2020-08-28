<?php

namespace OnzaMe\Images;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OnzaMe\Images\Skeleton\SkeletonClass
 */
class ImagesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'domda_backend_laravel_package_template';
    }
}
