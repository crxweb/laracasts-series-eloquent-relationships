<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Affiliation, Post, Profile, Tag, User};


class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        function makePosts(User $user){
            $tag_personal = Tag::whereName('personal')->first();
            $tag_family = Tag::whereName('family')->first();
            $tag_vacation = Tag::whereName('vacation')->first();

            $post = Post::factory()->create(['user_id' => $user->id]);
            $post->tags()->attach($tag_family->id, ['color' => 'blue']);

            $post = Post::factory()->create(['user_id' => $user->id]);
            $post->tags()->attach($tag_vacation->id, ['color' => 'blue']);

            $post = Post::factory()->create(['user_id' => $user->id]);
            $post->tags()->attach([
                $tag_personal->id => ['color' => 'red'],
                $tag_vacation->id => ['color' => 'blue'],
            ]);
        }

        $tag_family = Tag::factory()->create(['name'=>'family']);
        $tag_vacation = Tag::factory()->create(['name'=>'vacation']);
        $tag_personal = Tag::factory()->create(['name'=>'personal']);

        $affiliation_conservative = Affiliation::factory()->create(['name' => 'conservative']);
        $affiliation_liberal = Affiliation::factory()->create(['name' => 'liberal']);

        $user_1 = User::factory()->has(Profile::factory())->create(['affiliation_id' => $affiliation_conservative->id]);
        makePosts($user_1);
        $user_2 = User::factory()->has(Profile::factory())->create(['affiliation_id' => $affiliation_liberal->id]);
        makePosts($user_2);



        // User HasOne Profile, Many Profile
        /*
        $user = User::factory()
            ->has(Profile::factory())
            // User HasMany Posts - Post BelongsTo User
            ->has(Post::factory()->hasAttached( // Post BelongToMany Tags & Tag BelongToMany Posts
                Tag::factory()->count(2),
                ['color' => 'blue']
            )->count(5))
            ->create([
                'affiliation_id' => $affiliation_conservative->id,
            ]);*/
    }
}
