<?php

namespace TPG\Tests;

use Intervention\Image\ImageManager;
use TPG\ImageRenderer\Facades\ImageRenderer;
use TPG\Tests\Transformers\CustomTransformer;

class FacadeTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_have_new_transformers_added()
    {
        ImageRenderer::addTransformer('custom', CustomTransformer::class);

        $url = config('renderer.routes.base').'/test_image.jpg';

        $query = http_build_query([
            'custom' => '300,200'
        ]);

        $response = $this->get($url.'?'.$query);

        $image = (new ImageManager())->make($response->getContent());

        $this->assertEquals(300, $image->width());
        $this->assertEquals(200, $image->height());
    }
}
