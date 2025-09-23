<?php

namespace Feature;

use Tests\TestCase;

class DemoBannerTest extends TestCase
{
    public function test_demo_banner_invisible_by_default(): void
    {
        $response = $this->get('/app/1');

        $response->assertDontSeeText('This is a public demo site.');
    }
}
