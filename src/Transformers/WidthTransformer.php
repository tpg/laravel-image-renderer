<?php

namespace TPG\ImageRenderer\Transformers;

/**
 * Class WidthTransformer.
 */
class WidthTransformer extends Transformer
{
    /**
     * The transformer.
     *
     * @param $image
     * @param mixed ...$values
     * @return mixed
     */
    public function handle($image, ...$values)
    {
        $image->widen($values[0]);

        return $image;
    }
}
