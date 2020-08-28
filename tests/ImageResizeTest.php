<?php

namespace OnzaMe\Images\Tests;

use Intervention\Image\Facades\Image;
use OnzaMe\Images\ImageResize;
use OnzaMe\Images\ImagesServiceProvider;

class ImageResizeTest extends BaseTest
{
    public function test_resize()
    {
        $imagesPath = realpath(__DIR__.'/../resources/images').'/';

        $imageResize = new ImageResize();
        $optimizedImageFilepath = $imageResize->resize($imagesPath.'1.jpg', 480, 290, 100);
        $image = Image::make($optimizedImageFilepath);

        $this->assertEquals(480, $image->width());
        $this->assertEquals(290, $image->height());
        $this->generatedFiles[] = $optimizedImageFilepath;
    }
}
