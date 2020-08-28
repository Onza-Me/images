<?php

namespace OnzaMe\Images\Tests;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase;
use OnzaMe\Images\ImagesServiceProvider;

class BaseTest extends TestCase
{
    protected array $generatedFiles = [];

    protected function getPackageProviders($app)
    {
        return [ImagesServiceProvider::class];
    }

    public function test_true()
    {
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        foreach ($this->generatedFiles as $filepath) {
            !file_exists($filepath) ?: unlink($filepath);
        }
        parent::tearDown();
    }
}
