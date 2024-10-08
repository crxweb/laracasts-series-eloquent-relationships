<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Likable {

    public function like($user = null): void
    {
        $user = $user ?? auth()->user();
        $this->likes()->attach($user);
    }

    public function likes(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likable')->withTimestamps();
    }
}
