<?php

return [

    'routes' => [
        'base' => '/images',
        'middleware' => [],
    ],

    'storage' => [
        'disk' => 'local',
        'path' => 'images',
    ],

    'intervention' => [
        'driver' => 'gd',    // imagick
    ],

    'cache' => [
        'duration' => 60    // minutes,
    ],

    'transformers' => [
        'width' => TPG\ImageRenderer\Transformers\WidthTransformer::class,
        'height' => TPG\ImageRenderer\Transformers\HeightTransformer::class,
        'square' => TPG\ImageRenderer\Transformers\SquareTransformer::Class,
    ]
];
