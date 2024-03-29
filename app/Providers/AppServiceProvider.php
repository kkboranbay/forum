<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Cache::get('channels')) {
                $channels = Channel::all();
            } else {
                $channels = Cache::rememberForever('channels', function () {
                    return Channel::all();
                });
            }

            $view->with('channels', $channels);
        });

        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}
