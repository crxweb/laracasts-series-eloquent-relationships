<?php

namespace App\Models;

use App\Traits\Likable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use Likable, HasFactory;

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
