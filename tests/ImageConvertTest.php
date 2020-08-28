<?php

namespace OnzaMe\Images\Tests;

use Intervention\Image\Facades\Image;
use OnzaMe\Images\Images;

class ImageConvertTest extends BaseTest
{
    public function test_convert()
    {
        $imagesPath = realpath(__DIR__.'/../resources/images').'/';

        $images = new Images();
        $optimizedImageFilepath = $images->convert($imagesPath.'2.png', 'jpg');
        $this->assertIsString($optimizedImageFilepath);
        $image = Image::make($optimizedImageFilepath);
        $this->assertEquals('jpg', $image->extension);
        $this->assertFileExists($optimizedImageFilepath);

        $this->generatedFiles[] = $optimizedImageFilepath;
    }
}
