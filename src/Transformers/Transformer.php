<?php

namespace TPG\ImageRenderer\Transformers;

/**
 * Class Transformer
 */
abstract class Transformer
{
    /**
     * The transformer
     *
     * @param $image
     * @param mixed ...$values
     * @return mixed
     */
    abstract public function handle($image, ...$values);
}
