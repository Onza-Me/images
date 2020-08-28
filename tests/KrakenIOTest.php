<?php

namespace OnzaMe\Images\Tests;

use OnzaMe\Images\KrakenIO;

class KrakenIOTest extends BaseTest
{
    public function test_optimize_image()
    {
        $imagesPath = realpath(__DIR__.'/../resources/images').'/';
        $optimizedImagesPath = realpath(__DIR__.'/../resources/optimized_images').'/';
        $kraken = new KrakenIO(config('onzame_images.krakenio.api_key'), config('onzame_images.krakenio.api_secret'));
        $optimizedImageFilepath = $optimizedImagesPath.'1.jpg';
        $this->generatedFiles[] = $optimizedImageFilepath;
        $this->assertFileNotExists($optimizedImageFilepath);
        $this->assertTrue($kraken->optimize($imagesPath.'1.jpg', $optimizedImageFilepath));
        $this->assertFileExists($optimizedImageFilepath);
    }
}
