<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Affiliation, Note, Post, Profile, Tag, User, Video};


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
            $post->notes()->save(Note::factory()->make());

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
        $note_user1 = Note::factory()->make(['text' => "Cet utilisateur est un conservateur."]);
        dump($user_1->notes->count()); // (1)
        $user_1->notes()->save($note_user1); // Avec Save il faut refresh si on a déjà chargé la relation (1)
        $user_1->refresh();
        dump($user_1->notes->count());

        $user_2 = User::factory()->has(Profile::factory())->create(['affiliation_id' => $affiliation_liberal->id]);
        makePosts($user_2);
        dump($user_2->notes->count()); // (1)
        $user_2->notes()->create([ // Avec Create il faut refresh si on a déjà chargé la relation (1)
            'text' => 'Cet utilisateur est un libéral.',
        ]);
        $user_2->refresh();
        dump($user_2->notes->count());

        $user_3 = User::factory()->create();


        // Notes
        $note_for_user = Note::create(['text' => 'Rien de particulier', 'noteable_type' => User::class, 'noteable_id' => $user_2->id]);

        // Likes
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => User::factory()->create()]);
        $video = Video::factory()->create();
        $post->likes()->attach($user);
        $video->likes()->attach($user);

        $user = User::factory()->create();
        $video->likes()->attach($user);
        $video = Video::factory()->create();
        $post->likes()->attach($user);
        $video->likes()->attach($user);


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
