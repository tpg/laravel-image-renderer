<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    |
    | You can specify the route that will be registered with Laravel as well
    | as any route middleware that should be attached. Simply list the
    | middleware names as you would with any other route.
    |
    | You can also specify the name of the route. This is handy if you use
    | named routes in your app.
    |
    */

    'routes' => [
        'base' => '/images',
        'middleware' => [],
        'name' => 'images.render',
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage
    |--------------------------------------------------------------------------
    |
    | You need to tell the renderer where it can find images. The `disk`
    | setting can be any disk configured in the Laravel `filesystems.php`
    | config file. The `path` setting is the base directory within the
    | configured disk where images are stored.
    |
    */

    'storage' => [
        'disk' => 'local',
        'path' => 'images',
    ],

    /*
    |--------------------------------------------------------------------------
    | Intervention Image
    |--------------------------------------------------------------------------
    |
    | The renderer uses the `intervention/image` package to render images.
    | You can specify any configuration options that should be passed to the
    | `ImageManager` class.
    |
    | See http://image.intervention.io/getting_started/configuration.
    |
    */

    'intervention' => [
        'driver' => 'gd',    // imagick
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | The renderer will cache the transformation result and will set cache
    | headers for the response. Here you can customize the cache settings
    |
    */

    'cache' => [
        'duration' => 3600,     // seconds,

        'public' => true,       // Can the image be cached publicly?
    ],

    /*
    |--------------------------------------------------------------------------
    | Transformers
    |--------------------------------------------------------------------------
    |
    | You can specify the default available transformers here. The array key
    | is used as the query parameter name. You can also add transformers on
    | the fly using the `ImageRenderer::addTransformer()` method.
    |
    */

    'transformers' => [
        'width' => TPG\ImageRenderer\Transformers\WidthTransformer::class,
        'height' => TPG\ImageRenderer\Transformers\HeightTransformer::class,
        'square' => TPG\ImageRenderer\Transformers\SquareTransformer::class,
    ],
];
