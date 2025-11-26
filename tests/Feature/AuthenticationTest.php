<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_app_redirects_to_login(): void
    {
        $response = $this->get('/app');
        $response->assertRedirect('/app/login');
    }

    public function test_can_load_login_page(): void
    {
        $response = $this->get('/app/login');
        $response
            ->assertStatus(200)
            ->assertSee('regisztrálj')
            ->assertSee('Elfelejtetted')
            ->assertSee('Email cím')
            ->assertSee('Jelszó');
    }

    public function test_can_load_registration_page(): void
    {
        $response = $this->get('/app/register');
        $response
            ->assertStatus(200)
            ->assertSee('Név')
            ->assertSee('Email cím')
            ->assertSee('Jelszó')
            ->assertSee('Jelszó megerősítése');
    }

    public function test_can_load_password_reset(): void
    {
        $response = $this->get('/app/password-reset/request');
        $response
            ->assertStatus(200)
            ->assertSee('Email cím');
    }
}
