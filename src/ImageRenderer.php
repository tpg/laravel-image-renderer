<?php

namespace TPG\ImageActions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use TPG\ImageActions\Traits\TransformsImages;

class ImageRenderer
{
    use TransformsImages;

    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * ImageRenderer constructor.
     */
    public function __construct()
    {
        $this->imageManager = new ImageManager([
            'driver' => config('renderer.intervention.driver')
        ]);
    }

    public function render(string $path, array $options = [])
    {
        $image = $this->imageManager->make($this->imageData($path));

        if ($options) {
            $image = $this->transform($image, $options);
        }

        return $image->response();
    }

    protected function transform(Image $image, array $options)
    {
        foreach ($options as $key => $option) {
            $image = $this->{'transform' . Str::ucfirst($key)}($image, $option);
        }

        return $image;
    }

    protected function imageData(string $path)
    {
        return Storage::disk(config('renderer.storage.disk'))->get($path);
    }
}
