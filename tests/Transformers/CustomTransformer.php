<?php

namespace TPG\Tests\Transformers;

use TPG\ImageRenderer\Transformers\Transformer;

class CustomTransformer extends Transformer
{
    /**
     * The transformer
     *
     * @param $image
     * @param mixed ...$values
     * @return mixed
     */
    public function handle($image, ...$values)
    {
        $image->crop($values[0], $values[1]);

        return $image;
    }
}
