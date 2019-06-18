<?php

namespace TPG\Tests\Transformers;

use TPG\ImageRenderer\Transformers\Contracts\Transformer;

class CustomTransformer implements Transformer
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
        $image->crop($values[0], $values[1]);

        return $image;
    }
}
