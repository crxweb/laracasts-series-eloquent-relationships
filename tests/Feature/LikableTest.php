<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikableTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->actingAs(User::factory()->create());
        $post = Post::factory()->create(['user_id' => User::factory()->create()]);
        $post->like();
        $this->assertCount(1, $post->likes);
        $this->assertequals($post->likes->first()->id, auth()->id());
    }
}
