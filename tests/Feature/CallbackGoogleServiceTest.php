<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class CallbackGoogleServiceTest extends TestCase
{
    public function test_callback_google_throws_exception()
    {
        Socialite::shouldReceive('driver->user')
            ->once()
            ->andThrow(new \Exception('Google authentication failed.'));

        $response = $this->get('/auth/google-callback');

        $response->assertSeeText('Google authentication failed.');
        $this->assertGuest();
    }
}
