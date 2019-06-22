<?php

namespace TPG\ImageRenderer;

use Illuminate\Support\Arr;
use Intervention\Image\Image;
use Intervention\Image\ImageCache;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImageRenderer.
 */
class ImageRenderer
{
    /**
     * @var ImageManager
     */
    protected $imageManager;

    protected $transformers;

    /**
     * ImageRenderer constructor.
     */
    public function __construct()
    {
        $this->imageManager = new ImageManager([
            'driver' => config('renderer.intervention.driver'),
        ]);

        $this->transformers = config('renderer.transformers');
    }

    /**
     * Register a new transformer class.
     *
     * @param string $key
     * @param string $class
     */
    public function addTransformer(string $key, string $class): void
    {
        $this->transformers[$key] = $class;
    }

    /**
     * Render the image.
     *
     * @param string $path
     * @param array $options
     * @return Image|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function render(string $path, array $options = [])
    {
        if (! $options || count($options) === 0) {
            return $this->imageData($path);
        }

        $image = $this->prepareImage($path, $options);

        return $image;
    }

    /**
     * Prepare the image for output
     *
     * @param string $path
     * @param array $options
     * @return Image
     */
    protected function prepareImage(string $path, array $options = []): Image
    {
        return $this->imageManager->cache(function (ImageCache $cache) use ($path, $options) {
            $image = $cache->make($this->imageData($path));

            if ($options) {
                $image = $this->transform($image, $options);
            }

            return $image;
        }, config('renderer.intervention.cache.duration') / 60, true);
    }

    /**
     * Transform an image.
     *
     * @param ImageCache $image
     * @param array $options
     * @return ImageCache
     */
    protected function transform(ImageCache $image, array $options)
    {
        foreach ($options as $key => $value) {
            $class = Arr::get($this->transformers, $key);

            if (! $class) {
                throw new \InvalidArgumentException('No transformer with key '.$key);
            }

            (new $class)->handle($image, explode(',', $value));
        }

        return $image;
    }

    /**
     * Get image data.
     *
     * @param string $path
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function imageData(string $path)
    {
        return Storage::disk(config('renderer.storage.disk'))->get($path);
    }
}
