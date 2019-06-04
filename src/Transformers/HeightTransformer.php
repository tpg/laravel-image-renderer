<?php

namespace TPG\ImageRenderer\Transformers;

class HeightTransformer extends Transformer
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
        $image->heighten($values[0]);

        return $image;
    }
}
