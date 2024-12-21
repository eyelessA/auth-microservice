<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class RedirectToGoogleTest extends TestCase
{
    public function test_redirect_to_google()
    {
        Socialite::shouldReceive('driver->redirect')
            ->once()
            ->andReturn(redirect('https://accounts.google.com/o/oauth2/auth'));

        $response = $this->get('/auth/redirect');

        $response->assertRedirect('https://accounts.google.com/o/oauth2/auth');
    }
}
