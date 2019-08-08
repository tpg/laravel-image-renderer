# Laravel Image Renderer

[![Build Status](https://travis-ci.org/tpg/laravel-image-renderer.svg?branch=master)](https://travis-ci.org/tpg/laravel-image-renderer)

 A really simple solution to working with images in Laravel. Especially when using the Artisan `storage:link` command is not an option. 

## Installation

Like everything Laravel, the Image Renderer is installed using Composer. From the terminal, in your project root, run:

```bash
composer require thepublicgood/laravel-image-renderer
```

Once installed, you can publish the config file with:

```bash
php ./artisan vendor:publish --provider=TPG\ImageRenderer\ImageRendererServiceProvider
```

This will place a `renderer.php` config file in your project `/config` directory. Depending on your project, you may want to update some settings in the config file.

## Usage

A single route will be registered, the default is to use: `/images/{filename}` but this can be changed by altering the `routes.path` key in the config file.
You may also wish to alter the `storage` config options. By default, images are expected to be in `/storage/app/images`.

Once an image is stored in the correct location, a GET request to `http://mysite.test/images/filename.jpg` will render the image to the browser.
Sub-directories are also supported, so the file `/images/gallery/picture.jpg` can be rendered by pointing to `http://mysite.test/images/gallery/picture.jpg`.

## Transformers

The Laravel Image Renderer uses the `intervention/image` page to deal with reading and rendering the image. This means that images can be transformed on the fly. Three transformers are included by default: `height`, `width` and `square`. You can scale an image proportionately by passing the transformer name and value as a URL query:

```
http://mysite.test/images/filename.jpg?width=300
```

The `intervention/imagecache` package is also leveraged to cache the transforms so that they're not rerun on each request. To scale an image by it's height, you can use `height=300` or to create a square thumbnail you could use `square=400`. 

Transformers can be combined as well.

## Custom Transformers

You can write your own transforms by implementing the `TPG\ImageRenderer\Transformers\Contracts\Transformer` interface. All transformer classes must implement a `handle` method which accept two parameters, and be suffixed with `Transformer`:

```php
namespace App\Transformers;

use TPG\ImageRenderer\Transformers\Contracts\Transformer;

class MyTransformer implements Transformer
{
    public function handle($image, array $values)
    {
        $image->crop($values[0], $values[1]);
        
        return $image;
    }
}
```

The `$image` is an instance of the `Intervention\ImageCache` class and the `$values` array contains any values passed to the query. In the previous example, two values are expected. Remember to return the `$image` when the transformer is complete.

Once the transformer class is in place, the renderer needs to be told that the transformer is available. This can be done in two ways. You can either call the `addTransformer` method on the `ImageRenderer` facade from your `AppServiceProvider`:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        ImageRenderer::addTransformer(
            'custom',
            App\Transformers\MyTransformer::class
        );
    }
}

```

Or you can add it to the `transformers` config key:

```php
return [

    'transformers' => [
        // ...
        'custom' => App\Transformers\MyTransformer::class,
    ]

];
```

You can now use the transformer from the URL:

```
http://mysite.test/images/filename.jpg?custom=300,400
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change. Please see [CONTRIBUTING.md]() for mre details.

Please make sure to update tests as appropriate.

## License
This package is licensed under the [MIT](LICENSE.md) license.
