<?php

namespace TPG\ImageRenderer\Transformers;

class SquareTransformer extends Transformer
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
        $image->fit($values[0]);
    }
}
