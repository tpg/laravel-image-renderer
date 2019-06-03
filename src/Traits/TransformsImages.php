<?php

namespace TPG\ImageActions\Traits;

use Intervention\Image\Image;

trait TransformsImages
{
    protected function transformWidth(Image $image, $value)
    {
        $image->widen($value);

        return $image;
    }

    protected function transformHeight(Image $image, $value)
    {
        $image->heighten($value);

        return $image;
    }

    protected function transformSquare(Image $image, $value)
    {
        $image->fit($value);

        return $image;
    }
}
