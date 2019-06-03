<?php

return [

    'routes' => [
        'base' => '/images',
        'middleware' => []
    ],

    'storage' => [
        'disk' => 'local',
        'path' => 'images',
    ],

    'intervention' => [
        'driver' => 'gd'    // imagick
    ],

];
