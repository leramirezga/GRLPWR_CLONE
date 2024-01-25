<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ClientPlanController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SesionClienteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WelcomeController;
use App\Model\ClientPlan;
use \Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/mis_solicitudes/crear', 'SolicitudServicioController@irCrear')->name('irCrearSolicitud');
    Route::post('/mis_solicitudes/crear', 'SolicitudServicioController@save')->name('crearSolicitud');
    Route::get('/{user}/mis_solicitudes/{solicitud}/editar', 'SolicitudServicioController@irEditar')->name('irEditarSolicitud');
    Route::put('/mis_solicitudes/{solicitud}/editar', 'SolicitudServicioController@editar')->name('editarSolicitud');
    Route::post('/mis_solicitudes/tutorialCreacion', 'SolicitudServicioController@tutorialCreacionCompletado');

    Route::get('/{user}/mis_solicitudes/{solicitud}', 'SolicitudServicioController@show')->where(['solicitud' => '[0-9]+'])->name('solicitud');

    Route::get('/busquedaProyectos/', 'BusquedaProyectoController@buscarProyectos')->name('buscarProyecto');
    Route::post('/busquedaProyectos/', 'BusquedaProyectoController@filtrar')->name('buscarProyecto.filtrar');

    Route::get('/ofertar/{solicitud}', 'BusquedaProyectoController@irOfertar')->name('ofertar');
    Route::post('/ofertar/{solicitud}', 'BusquedaProyectoController@crearOferta')->name('crearPropuesta');
    Route::put('/ofertar/{solicitud}', 'BusquedaProyectoController@actualizarOferta')->name('actualizarPropuesta');
    Route::delete('/ofertar/{solicitud}', 'BusquedaProyectoController@eliminarOferta')->name('eliminarPropuesta');
    Route::put('confirmarPropuesta', 'BusquedaProyectoController@confirmarOferta')->name('confirmarPropuesta');

    Route::get('/autocomplete', 'AutoCompleteController@index');
    Route::post('/autocomplete/fetch', 'AutoCompleteController@fetch')->name('autocomplete.fetch');

    Route::get('/user/{user}/home', 'HomeController@index')->name('home');
    Route::delete('/{user}/home', 'SolicitudServicioController@eliminar')->name('eliminarSolicitud');
    Route::put('/user/{user}/home', [ProfileController::class, 'actualizarPerfil'])->name('actualizarPerfil');
    Route::get('/visitar/{user}', 'HomeController@visitar')->name('visitarPerfil');

    Route::get('/user/{user}', 'ProfileController@index')->name('profile');

    Route::put('completar_registro_redes_sociales', 'HomeController@completarRegistroRedesSociales')->name('completarRegistroRedesSociales');

    Route::get('/busquedaEntrenadores/', 'BusquedaEntrenadorController@buscarEntrenador')->name('buscarEntrenadores');
    Route::post('/busquedaEntrenadores/', 'BusquedaEntrenadorController@filtrar')->name('buscarEntrenadores.filtrar');

    Route::post('/crearBlog', 'BlogsController@crearBlog')->name('crearBlog');
    Route::post('/editarBlog', 'BlogsController@editarBlog')->name('editarBlog');

    Route::post('/insert-image', 'BlogsController@insertImage');
    Route::post('/upload-image', 'BlogsController@uploadImage');
    Route::post('/rotate-image', 'BlogsController@uploadImage');//TODO ROTATE AND CROP

    Route::get('/eventos/crear', [EventController::class, 'create'])->name('eventos.create');
    Route::get('/eventos/{event}/{date}/{hour}/{isEdited}', [EventController::class, 'show'])->name('eventos.show');
    Route::post('/eventos/crear', [EventController::class, 'save'])->name('eventos.store');

    //Route::get('/eventos', [SesionEventoController::class, 'fullcalendar'])->name('eventos');
    Route::post('/agendar', [SesionClienteController::class, 'save'])->name('agendar');

    Route::post('/response_payment',[PagosController::class, 'responsePayment']);
    Route::get('/response_payment', [PagosController::class, 'responsePayment']);

    Route::post('/scheduleEvent',[SesionClienteController::class, 'scheduleEvent'])->name('scheduleEvent');
    Route::post('/dar_review_entrenamiento/', [SesionClienteController::class, 'darReview'])->name('darReviewEntrenamiento');
    Route::delete('/cancelar_entrenamiento', [SesionClienteController::class, 'cancelTraining'])->name('cancelarEntrenamiento');
    Route::get('/planes/{plan}', [PlanController::class, 'show'])->name('plan');

    Route::get('/clientLastPlanWithRemainingClasses', [ClientPlan::class, 'clientLastPlanWithRemainingClasses'])->name('clientLastPlanWithRemainingClasses');


    Route::get('/nextSessions/{branchId}',[EventController::class, 'nextSessions'])->name('nextSessions');
});
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/loadPlan', [ClientPlanController::class, 'showLoadClientPlan']);
    Route::post('/admin/loadPlan', [ClientPlanController::class, 'saveClientPlan'])->name('saveClientPlan');
});

/*Open routes*/
    Auth::routes();

    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

    Route::get('/planes', [PlanController::class, 'index'])->name('plans');

    Route::post('notification/get', 'NotificationController@get');
    Route::post('/notification/read', 'NotificationController@read');

    Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
    Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

    Route::get('/blogs', 'BlogsController@allBlogs')->name('blogs');
    Route::get('/{user}/blog', 'BlogsController@blogUsuario')->name('blogsUsuario');
    Route::get('/blog/{blog}', 'BlogsController@verBlog')->name('blog');
    Route::post('/comentar/{blog}', 'BlogsController@comentarBlog')->name('comentarblog');
    Route::post('/reply/{comentario}', 'BlogsController@replyComentario')->name('replyComentario');

    Route::get('/loadSessions',[EventController::class, 'ajaxNextSessions'])->name('loadSessions');

    Route::post('/scheduleCourtesy',[SesionClienteController::class, 'scheduleCourtesy'])->name('scheduleCourtesy');
/*End Open routes*/