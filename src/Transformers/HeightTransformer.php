<?php

namespace TPG\ImageRenderer\Transformers;

use TPG\ImageRenderer\Transformers\Contracts\Transformer;

class HeightTransformer implements Transformer
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
        $image->heighten($values[0]);

        return $image;
    }
}
