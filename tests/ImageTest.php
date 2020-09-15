<?php

namespace TPG\Tests;

use Illuminate\Support\Facades\Config;
use Intervention\Image\ImageManager;
use TPG\Tests\Transformers\CustomTransformer;

class ImageTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_render_an_image()
    {
        $this->withoutExceptionHandling();

        $imagePath = config('renderer.routes.base').'/test_image.jpg';

        $this->get($imagePath)
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'image/jpeg');
    }

    /**
     * @test
     */
    public function it_can_render_an_image_using_a_route_name()
    {
        $this->withoutExceptionHandling();

        $route = route(config('renderer.routes.name'), ['test_image.jpg']);

        $this->get($route)
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'image/jpeg');
    }

    /**
     * @test
     */
    public function it_will_return_a_404_for_missing_images()
    {
        $imagePath = config('renderer.routes.base').'/missing-image.jpg';

        $this->get($imagePath)->assertStatus(404);
    }

    /**
     * @test
     */
    public function it_can_transform_an_image()
    {
        $this->withoutExceptionHandling();
        $imagePath = config('renderer.routes.base').'/test_image.jpg';

        $query = http_build_query([
            'width' => 300,
        ]);

        $response = $this->get($imagePath.'?'.$query);

        $image = (new ImageManager())->make($response->getContent());

        $this->assertEquals(300, $image->width());

        $query = http_build_query([
            'height' => 300,
        ]);

        $response = $this->get($imagePath.'?'.$query);

        $image = (new ImageManager())->make($response->getContent());

        $this->assertEquals(300, $image->height());

        $query = http_build_query([
            'square' => 250,
        ]);
        $response = $this->get($imagePath.'?'.$query);

        $image = (new ImageManager())->make($response->getContent());

        $this->assertEquals(250, $image->width());
        $this->assertEquals(250, $image->height());
    }

    /**
     * @test
     */
    public function it_will_throw_an_exception_for_an_invalid_transform()
    {
        $this->withoutExceptionHandling();

        $imagePath = config('renderer.routes.base').'/test_image.jpg';

        $query = http_build_query([
            'invalid' => 500,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $this->get($imagePath.'?'.$query);
    }

    /**
     * @test
     */
    public function custom_transformers_can_be_used()
    {
        Config::set('renderer.transformers.custom', CustomTransformer::class);

        $imagePath = config('renderer.routes.base').'/test_image.jpg';

        $query = http_build_query([
            'custom' => '300,200',
        ]);

        $response = $this->get($imagePath.'?'.$query);

        $image = (new ImageManager())->make($response->getContent());

        $this->assertEquals(300, $image->width());
        $this->assertEquals(200, $image->height());
    }
}
