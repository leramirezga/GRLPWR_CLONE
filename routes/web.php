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

use App\Http\Controllers\PagosController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SesionClienteController;
use App\Http\Controllers\SesionEventoController;
use \Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if(Auth::check()){
        return redirect(Auth::user()->slug.'/home');
    }
    return view('welcome');
});

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

    Route::get('/{user}/home', 'HomeController@index')->name('home');
    Route::delete('/{user}/home', 'SolicitudServicioController@eliminar')->name('eliminarSolicitud');
    Route::put('/{user}/home', 'HomeController@actualizarPerfil')->name('actualizarPerfil');
    Route::get('/visitar/{user}', 'HomeController@visitar')->name('visitarPerfil');

    Route::put('completar_registro_redes_sociales', 'HomeController@completarRegistroRedesSociales')->name('completarRegistroRedesSociales');

    Route::get('/busquedaEntrenadores/', 'BusquedaEntrenadorController@buscarEntrenador')->name('buscarEntrenadores');
    Route::post('/busquedaEntrenadores/', 'BusquedaEntrenadorController@filtrar')->name('buscarEntrenadores.filtrar');

    Route::post('/crearBlog', 'BlogsController@crearBlog')->name('crearBlog');
    Route::post('/editarBlog', 'BlogsController@editarBlog')->name('editarBlog');

    Route::post('/insert-image', 'BlogsController@insertImage');
    Route::post('/upload-image', 'BlogsController@uploadImage');
    Route::post('/rotate-image', 'BlogsController@uploadImage');//TODO ROTATE AND CROP

    Route::get('/eventos/{sesion}', [SesionEventoController::class, 'show'])->name('evento');
    Route::get('/eventos', [SesionEventoController::class, 'fullcalendar'])->name('eventos');
    Route::post('/agendar', [SesionClienteController::class, 'save'])->name('agendar');

    Route::post('/response_payment',[PagosController::class, 'responsePayment']);
    Route::get('/response_payment', [PagosController::class, 'responsePayment']);

    Route::post('/scheduleEvent',[SesionClienteController::class, 'scheduleEvent'])->name('scheduleEvent');
    Route::post('/dar_review_entrenamiento/', [SesionClienteController::class, 'darReview'])->name('darReviewEntrenamiento');
    Route::delete('/cancelar_entrenamiento', [SesionClienteController::class, 'cancelTraining'])->name('cancelarEntrenamiento');
    Route::get('/plans/{plan}', [PlanController::class, 'show'])->name('plans');

});
/*Route::resources([
    'mis_solicitudes' => 'SolicitudServicioController',
]);*/

Auth::routes();

Route::post('notification/get', 'NotificationController@get');
Route::post('/notification/read', 'NotificationController@read');

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

Route::get('/blogs', 'BlogsController@allBlogs')->name('blogs');
Route::get('/{user}/blog', 'BlogsController@blogUsuario')->name('blogsUsuario');
Route::get('/blog/{blog}', 'BlogsController@verBlog')->name('blog');
Route::post('/comentar/{blog}', 'BlogsController@comentarBlog')->name('comentarblog');
Route::post('/reply/{comentario}', 'BlogsController@replyComentario')->name('replyComentario');