<?php

namespace App\Providers;

use App\Branch;
use App\ClassType;
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

        Facades\View::composer('components.branchSelector', function (View $view) {
            $branches = Branch::all();
            $view->with('branches', $branches);
        });

        Facades\View::composer('components.classTypeSelector', function (View $view) {
            $classTypes = ClassType::all();
            $view->with('classTypes', $classTypes);
        });
    }
}
