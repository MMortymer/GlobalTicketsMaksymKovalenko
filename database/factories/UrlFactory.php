<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UrlFactory extends Factory
{
    protected $model = Url::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'original_url' => $this->faker->url,
            'shortened_url' => Str::random(7),
        ];
    }
}
