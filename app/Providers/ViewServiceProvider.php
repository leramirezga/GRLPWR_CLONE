<?php

namespace App\Providers;

use App\Branch;
use App\ClassType;
use App\Model\ClientPlan;
use App\Model\Evento;
use App\Repositories\ClientPlanRepository;
use App\View\Composers\HistoricActiveClientsComposer;
use App\View\Composers\EventComposer;
use App\View\Composers\HighlightComposer;
use App\View\Composers\PhysicalAssessmentComposer;
use App\View\Composers\TrainingPreferencesComposer;
use App\View\Composers\WheelOfLifeComposer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
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

        $route = Route::current(); // Illuminate\Routing\Route
        Facades\View::composer('cliente.clientPlan', function (View $view) {
            $route = Route::current(); // Illuminate\Routing\Route
            $clientPlanRepository = new ClientPlanRepository();
            $clientPlans = $clientPlanRepository->findValidClientPlans(clientId: $route->parameter('user')->id);
            $expiredPlans = ClientPlan::where('client_id', '=', $route->parameter('user')->id)
                ->where('client_plans.expiration_date', '<', Carbon::now())
                ->join('plans', 'client_plans.plan_id', '=', 'plans.id')
                ->select('client_plans.*', 'plans.name')
                ->get();
            $view->with(
                ['clientPlans' => $clientPlans,
                'expiredPlans' => $expiredPlans]
            );
        });

        Facades\View::composer('assessments.physicalAssessment', PhysicalAssessmentComposer::class);
        Facades\View::composer('assessments.wheelOfLife', WheelOfLifeComposer::class);
        Facades\View::composer('cliente.trainingPreferences', TrainingPreferencesComposer::class);
        Facades\View::composer('highlightSection', HighLightComposer::class);
        Facades\View::composer('components.historicActiveClients', HistoricActiveClientsComposer::class);
    }
}
