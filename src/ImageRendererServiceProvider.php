<?php

namespace TPG\ImageRenderer;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TPG\ImageRenderer\Http\Controllers\ImageController;

class ImageRendererServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::group([
            'prefix' => config('renderer.routes.base'),
            'middleware' => config('renderer.middleware'),
        ], function () {
            Route::get('{key}', ImageController::class)
                ->where('key', '.+')
                ->name(config('renderer.routes.name'));
        });

        $this->publishes([
            __DIR__.'/../config/renderer.php' => config_path('renderer.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/renderer.php', 'renderer');

        $this->app->singleton('laravel-image-renderer.facade', function () {
            return new ImageRenderer();
        });
    }
}
