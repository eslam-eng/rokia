<?php

namespace App\Providers;

use App\Models\Lecture;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'user'=>User::class,
            'slider'=>Slider::class,
            'lecture'=>Lecture::class,
        ]);
    }
}
