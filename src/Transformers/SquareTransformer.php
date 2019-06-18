<?php

namespace TPG\ImageRenderer\Transformers;

use TPG\ImageRenderer\Transformers\Contracts\Transformer;

class SquareTransformer implements Transformer
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
        $image->fit($values[0]);
    }
}
