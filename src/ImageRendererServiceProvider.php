<?php

namespace TPG\ImageActions;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TPG\ImageActions\Http\Controllers\ImageController;

class ImageRendererServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::group([
            'prefix' => config('renderer.routes.base'),
            'middleware' => config('renderer.middleware'),
        ], function () {
            Route::get('{key}', ImageController::class);
        });

        $this->publishes([
            __DIR__.'/../config/renderer.php' => config_path('renderer.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/renderer.php', 'renderer');
    }
}
