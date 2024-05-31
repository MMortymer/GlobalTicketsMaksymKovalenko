<?php

namespace Tests\Feature;

use App\Models\Url;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Str;
    use Tests\TestCase;

class UrlApiControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method.
     */
    public function test_index()
    {
        Url::factory()->count(5)->create();

        $response = $this->getJson(route('urls.index'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'links',
                     'meta'
                 ]);
    }

    /**
     * Test the show method.
     */
    public function test_show()
    {
        $url = Url::factory()->create();

        $response = $this->getJson(route('urls.show', $url->id));

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'urlId' => $url->id,
                         'userId' => $url->user_id,
                         'originalUrl' => $url->original_url,
                         'shortenedUrl' => $url->shortened_url,
                     ]
                 ]);
    }

    /**
     * Test the store method.
     */
    public function test_store()
    {
        $user = User::factory()->create();

        $data = [
            'original_url' => 'https://www.example.com',
            'user_id' => $user->id,
        ];

        $response = $this->postJson(route('urls.store'), $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'userId' => $user->id,
                         'originalUrl' => 'https://www.example.com',
                     ]
                 ]);

        $this->assertDatabaseHas('urls', [
            'original_url' => 'https://www.example.com',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test the update method.
     */
    public function test_update()
    {
        $url = Url::factory()->create();

        $data = [
            'original_url' => 'https://www.updated-example.com',
        ];

        $response = $this->putJson(route('urls.update', $url->id), $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'urlId' => $url->id,
                         'originalUrl' => 'https://www.updated-example.com',
                     ]
                 ]);

        $this->assertDatabaseHas('urls', [
            'id' => $url->id,
            'original_url' => 'https://www.updated-example.com',
        ]);
    }

    /**
     * Test the destroy method.
     */
    public function test_destroy()
    {
        $url = Url::factory()->create();

        $response = $this->deleteJson(route('urls.destroy', $url->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('urls', [
            'id' => $url->id,
        ]);
    }
}
