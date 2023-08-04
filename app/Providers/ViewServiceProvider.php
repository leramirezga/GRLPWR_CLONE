<?php

namespace App\Providers;

use App\Model\Evento;
use App\View\Composers\EventComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;
use Illuminate\View\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Facades\View::composer('proximasSesiones', EventComposer::class);

        Facades\View::composer('sessions.createSession', function (View $view) {
            $events = Evento::all();
            $view->with('events', $events);
        });
    }
}
