# Laracasts Series - eloquent-relationships

https://laracasts.com/series/eloquent-relationships

- One to One
- One to Many
- Many to Many
- Has Many Through
- Polymorphic Relations
- Many to Many Polymorphic Relations

## One to One - HasOne / BelongTo

> User HasOne Profile & Profile BelongsTo User<br>
> L'utilisateur a 1 profil & 1 profil appartient à 1 utilisateur

![img.png](documentation/images/user_hasone_profile_dbb.png)

Migration
```php
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->unique()->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('website_url');
            $table->string('github_url');
            $table->string('twitter_url');
            $table->timestamps();
        });
```

Models:
```php
// App\Models\User
    
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
```

```php
// App\Models\Profile
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
```

Utilisation:
```php 

use App\Models\{Profile, User};

DB::enableQueryLog();

$user = User::find(1);
$user->profile; // @return App\Models\Profile - Une requête SQL est exécutée pour retrouver le Profile
$user->profile(); // @return Illuminate\Database\Eloquent\Relations\HasOne

DB::getQueryLog();
```

## One to Many - HasMany / BelongTo


> User HasMany Posts & Post BelongsTo User<br>
> L'utilisateur a plusieurs Posts & un Post appartient à 1 utilisateur

![img.png](documentation/images/user_hasmany_posts.png)

Migration:
```php 
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title');
            $table->string('body');
            $table->timestamps();
        });
```

Models:
```php
// App\Models\User
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

// App\Models\Post
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
```
Utilisation:
```php
use App\Models\{Post, User};

DB::enableQueryLog();

$user = User::find(1);
$user->posts; // Illuminate\Database\Eloquent\Collection Post
$user->posts(); // Illuminate\Database\Eloquent\Relations\HasMany

$posts = Post::where('user_id', $user->id)->get();
$posts = Post::whereBelongsTo($user)->get();

$users = User::where('vip', true)->get();
$posts = Post::whereBelongsTo($users)->get();

DB::getQueryLog();
```

:warning: N+1 Query Problem - Lazy loading
```php
// app/Providers/AppServiceProvider.php
    public function boot(): void
    {
        //Model::shouldBeStrict($this->app->isLocal());
        Model::preventLazyLoading($this->app->isLocal());
    }
```
```php
$user = User::with('posts')->first(); // Illuminate\Database\LazyLoadingViolationException
$user = User::with([
    'posts' => fn ($posts) => $posts->chaperone(),
])->first();

foreach ($user->posts as $post) {
    // Eloquent n'hydrate pas automatiquement la relation du parent (Ici User car Post issue du parent User via loop $user->posts)
    dump($post->user->email);
}
```
