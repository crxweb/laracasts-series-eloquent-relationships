<?php

namespace App\Models;

use App\Traits\Likable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use Likable, HasFactory;

    protected $fillable = ['title', 'body'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tags(): belongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps()->withPivot('color');
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    /*
    public function like($user = null): void
    {
        $user = $user ?? auth()->user();
        $this->likes()->attach($user);
    }

    public function likes(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likable');
    }
    */
}
