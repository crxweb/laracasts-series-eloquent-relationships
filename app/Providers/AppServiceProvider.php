<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict($this->app->isLocal());
        //Model::preventLazyLoading($this->app->isLocal());

        /*
        Relation::morphMap([
            'user' => 'App\Models\User',
            'post' => 'App\Models\Post',
        ]);*/
    }
}
