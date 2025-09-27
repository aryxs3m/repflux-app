<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_homepage_redirects(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }
}
