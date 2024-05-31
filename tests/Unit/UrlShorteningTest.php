<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class UrlShorteningTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test URL shortening logic.
     *
     * @return void
     */
    public function testUrlShortening()
    {
        $user = User::factory()->create();  // Create a user

        do {
            $shortenedUrl = Str::random(7);
        } while (Url::where('shortened_url', $shortenedUrl)->exists());

        $url = Url::create([
            'user_id' => $user->id,
            'original_url' => 'https://www.example.com',
            'shortened_url' => $shortenedUrl,
        ]);

        $this->assertDatabaseHas('urls', [
            'original_url' => 'https://www.example.com',
            'shortened_url' => $url->shortened_url,
        ]);
    }
}
