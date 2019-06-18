<?php

namespace TPG\ImageRenderer\Facades;

use Intervention\Image\Image;
use Illuminate\Support\Facades\Facade;

/**
 * Class ImageRendererFacade.
 *
 * @method static Image|null render(string $path, array $options = [])
 * @method static void addTransformer(string $key, string $class)
 */
class ImageRenderer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-image-renderer.facade';
    }
}
