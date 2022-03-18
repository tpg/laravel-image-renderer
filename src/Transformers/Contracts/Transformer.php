<?php

namespace TPG\ImageRenderer\Transformers\Contracts;

/**
 * Class Transformer.
 */
interface Transformer
{
    /**
     * The transformer.
     *
     * @param $image
     * @param  array  $values
     * @return mixed
     */
    public function handle($image, array $values);
}
