<?php

namespace TPG\Tests;

use Intervention\Image\ImageManager;

class ImageTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_render_an_image()
    {
        $this->withoutExceptionHandling();

        $imagePath = config('renderer.routes.base') . '/test_image.jpg';

        $this->get($imagePath)
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'image/jpeg');
    }

    /**
     * @test
     */
    public function it_will_return_a_404_for_missing_images()
    {
        $imagePath = config('renderer.routes.base') . '/missing-image.jpg';

        $this->get($imagePath)->assertStatus(404);
    }

    /**
     * @test
     */
    public function it_can_transform_an_image()
    {
        $imagePath = config('renderer.routes.base') . '/test_image.jpg';

        $query = http_build_query([
            'width' => 300
        ]);

        $response = $this->get($imagePath . '?' . $query);

        $image = (new ImageManager())->make($response->getContent());

        $this->assertEquals(300, $image->width());
    }
}
