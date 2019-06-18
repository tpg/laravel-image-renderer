<?php

namespace TPG\ImageRenderer\Transformers;

use TPG\ImageRenderer\Transformers\Contracts\Transformer;

/**
 * Class WidthTransformer.
 */
class WidthTransformer implements Transformer
{
    /**
     * The transformer.
     *
     * @param $image
     * @param array $values
     * @return mixed
     */
    public function handle($image, array $values)
    {
        $image->widen($values[0]);

        return $image;
    }
}
