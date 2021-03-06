<?php

namespace TPG\Tests;

use Illuminate\Support\Facades\Storage;
use TPG\ImageRenderer\Facades\ImageRenderer;
use TPG\ImageRenderer\ImageRendererServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! $this->storageDisk()->exists('images')) {
            $this->storageDisk()->makeDirectory('images');
        }
        copy(__DIR__.'/media/test_image_640_480.jpg', storage_path('app/images/test_image.jpg'));
    }

    protected function tearDown(): void
    {
        $this->storageDisk()->deleteDirectory('images');
    }

    protected function storageDisk()
    {
        return Storage::disk(config('renderer.storage.disk'));
    }

    protected function getPackageProviders($app)
    {
        return [
            ImageRendererServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ImageRenderer' => ImageRenderer::class,
        ];
    }
}
