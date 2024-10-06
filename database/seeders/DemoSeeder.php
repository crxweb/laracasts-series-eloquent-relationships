<?php

namespace Database\Seeders;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Post, Profile, User};


class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User HasOne Profile, Many Profile
        $user = User::factory()
            ->has(Profile::factory())
            ->has(Post::factory()->count(5))
            ->create();
    }
}
