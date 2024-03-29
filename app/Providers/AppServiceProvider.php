<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
            'success' => function () {
                return Session::get('success')
                    ? Session::get('success')->getBag('default')->getMessages()
                    : (object) [];
            },
            'user' => function () {
                return Session::get('user')
                    ? Session::get('user')->getBag('default')->getMessages()
                    : (object) [];
            }
        ]);
    }
}
