<?php

namespace Database\Seeders;

use App\Models\Url;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing data
        DB::table('users')->truncate();
        DB::table('urls')->truncate();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        Url::factory()->count(10)->create(['user_id' => $user->id]);
        
        $users = User::factory(10)->create(); // Create 10 users
        // Seed URLs for each user
        $users->each(function ($user) {
            Url::factory()->count(10)->create(['user_id' => $user->id]);
        });
    }
}
