# Laravel Image Actions

 A really simple solution to working with images in Laravel. Especially when using the Artisan `storage:link` command is not an option. 

## Installation

Like everything Laravel, Image Actions is installed using Composer. From the terminal, in your project root, run:

```bash
composer require tpg/laravel-image-renderer
```

Once installed, you can publish the config file with:

```bash
php ./artisan vendor:publish --provider=TPG\ImageActions\ImageActionsServiceProvider
```

This will place an `image-renderer.php` config file in your project `/config` directory. Depending on your project, you may want to update some settings in the config file.

## Usage

A single route will be registered, the default is to use: `/images/{filename}` but this can be changed by altering the `routes.path` key in the config file.
You may also wish to alter the `storage` config options. By default, images are expected to be in `/storage/app/images`.

Once an image is stored in the correct directly, a GET request to `http://mysite.test/images/filename.jpg` will render the image to the browser.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change. Please see [CONTRIBUTING.md]() for mre details.

Please make sure to update tests as appropriate.

## License
This package is licensed un the [MIT](LICENSE.md) license.
