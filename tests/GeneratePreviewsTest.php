<?php

namespace OnzaMe\Images\Tests;

use Intervention\Image\Facades\Image;
use OnzaMe\Images\ImageResize;
use OnzaMe\Images\Images;
use OnzaMe\Images\ImagesServiceProvider;

class GeneratePreviewsTest extends BaseTest
{
    public function test_generate_previews()
    {
        $imagesPath = realpath(__DIR__.'/../resources/images').'/';

        $images = new Images();
        $imagesPaths = $images->generatePreviews($imagesPath.'1.jpg', 'photos');
        $this->generatedFiles = array_merge($this->generatedFiles, $imagesPaths);
        foreach ($imagesPaths as $imagePath) {
            $this->assertFileExists($imagePath);
        }
    }
}
