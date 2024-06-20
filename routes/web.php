    <?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
use App\Http\Controllers\NotificarController;
use Illuminate\Support\Facades\Route;
use App\Models\User\User;
use App\Http\Controllers\Auth\LoginController;
//use App\Http\Controllers\User\UserController;
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
Auth::routes();

Route::get('idioma/{lang}', 'Lenguaje\LenguajeController@cambioLenguaje')
            ->name('idioma.cambioLenguaje');

Route::get('/deny', function () {
    return view('deny');
});

Route::get('/check_your_mail', function () {
    return view('adminlte::mail.check_your_mail');
});

Route::get('/', function () {
    return view('welcome');
});

/**
 * Se creó un middleware('permiso:user,view') el cual verifica antes de
 * acceder al recurso solicitado si el usuario tiene permiso de ver dicho recurso.
 * Este middleware es parte de la seguridad de la aplicación en conjunto cn los permisos
 * asignados a cada rol.
 * /
 // *********************************************************************************************************
    /*
    * Grupo Middleware para Autenticar y verifcar que tiene Permiso asociado a su Rol
    */
// *********************************************************************************************************
Route::group(['middleware' => 'auth'], function () {

    Route::get('/mail', 'Mail\MailController@index')->name('mail.index');
    Route::get('/homework', 'Tarea\TareaController@index')->name('homework.index');
    // *********************************************************************************************************
    /*
    * Rutas de Usuarios, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/notificaciones', 'Notification\NotificationController@index')->name('notificaciones.index');
    Route::get('/notificaciones/list', 'Notification\NotificationController@getNotifications')->name('notificaciones.list');
    Route::get('/notificaciones/read/{id}', 'Notification\NotificationController@setNotifications')->name('notificaciones.setNotifications');
    /*
    * Fin de las Rutas de Usuarios, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************
    /*
    * Rutas de Usuarios, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    // Route::post('/login', 'Auth\LoginController@login')->name('login');
    // Route::post('/login2', 'Auth\LoginController@login2')->name('login2');
    Route::get('/users', 'User\UserController@index')->name('users.index')->middleware('permiso:user,view');
    Route::get('/users/create', 'User\UserController@create')->name('users.create')->middleware('permiso:user,add');
    Route::post('/users', 'User\UserController@store')->name('users.store')->middleware('permiso:user,add');
    Route::get('/users/{user}/view', 'User\UserController@view')->name('users.view')->middleware('permiso:user,view');
    Route::get('/users/{user}/edit', 'User\UserController@edit')->name('users.edit')->middleware('permiso:user,edit');
    Route::post('/users/{user}', 'User\UserController@update')->name('users.update')->middleware('permiso:user,update');
    Route::get('/users/{user}/delete', 'User\UserController@destroy')->name('users.destroy')->middleware('permiso:user,delete');
    Route::get('/users/list', 'User\UserController@getUsers')->name('users.list')->middleware('permiso:user,view');
    Route::get('/users/profile', 'User\UserController@profile')->name('users.profile');
    Route::post('/users/profile/{id}', 'User\UserController@update_avatar')->name('users.profile')->middleware('permiso:user,update');
    Route::get('/users/usuarioRol', 'User\UserController@usuarioRol')->name('users.usuarioRol');
    Route::get('/users/notificationsUser', 'User\UserController@notificationsUser')->name('users.notificationsUser');
    Route::get('/users/print', 'User\UserController@usersPrint')->name('users.usersPrint')->middleware('permiso:user,print');
    Route::get('/users/color_view', 'User\UserController@colorView')->name('users.colorView');
    Route::get('/users/color_change', 'User\UserController@colorChange')->name('users.colorChange');
    /*
    * Fin de las Rutas de Usuarios, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************
    /*
    * Rutas de Permiso, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/permisos', 'Permiso\PermisoController@index')
    ->name('permisos.index')->middleware('permiso:permiso,view');

    Route::get('/permisos/list', 'Permiso\PermisoController@getModulos')
    ->name('permisos.list')->middleware('permiso:permiso,view');

    Route::get('/permisos/create', 'Permiso\PermisoController@create')
    ->name('permisos.create')->middleware('permiso:permiso,add');

    Route::post('/permisos','Permiso\PermisoController@store')
    ->name('permisos.store')->middleware('permiso:permiso,add');

    Route::post('/permisos/{permiso}','Permiso\PermisoController@show')
    ->name('permisos.show')->middleware('permiso:permiso,view');

    Route::get('/permisos/{permiso}/edit','Permiso\PermisoController@edit')
    ->name('permisos.edit')->middleware('permiso:permiso,edit');
// Parte importante para Actualizar los cambios realizados a los permisos .//////////////////
    Route::post('/permisos/{id}/{accion}/{allow_deny}','Permiso\PermisoController@update')
    ->name('permisos.update')->middleware('permiso:permiso,update');

    Route::post('/permisos/{id}/{allow_deny}','Permiso\PermisoController@updateAllPermisos')
    ->name('permisos.updateAllPermisos');

    Route::get('/permisos/{modulo_id}/{rol_id}','Permiso\PermisoController@getPermisos')
    ->name('permisos.getPermisos')->middleware('permiso:permiso,view');
// Parte importante para Actualizar los cambios realizados a los permisos .//////////////////
    Route::post('/permisos/{permiso}/delete','Permiso\PermisoController@destroy')
    ->name('permisos.destroy')->middleware('permiso:permiso,delete');

    Route::get('/permisos/print', 'Permiso\PermisoController@permisoPrint')
    ->name('permisos.permisoPrint')->middleware('permiso:permiso,print');
    /*
    * Fin de las Rutas de Permiso, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************
    /*
    * Rutas de Roles, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/rols', 'Rol\RolController@index')->name('rols.index')->middleware('permiso:rol,view');
    Route::get('/rols/create', 'Rol\RolController@create')->name('rols.create')->middleware('permiso:rol,add');
    Route::post('/rols', 'Rol\RolController@store')->name('rols.store')->middleware('permiso:rol,add');
    Route::get('/rols/{rol}/show', 'Rol\RolController@show')->name('rols.show')->middleware('permiso:rol,view');
    Route::get('/rols/{rol}/edit', 'Rol\RolController@edit')->name('rols.edit')->middleware('permiso:rol,edit');
    Route::post('/rols/{rol}', 'Rol\RolController@update')->name('rols.update')->middleware('permiso:rol,update');
    Route::get('/rols/{rol}/delete', 'Rol\RolController@destroy')->name('rols.destroy')->middleware('permiso:rol,delete');
    Route::get('/rols/list', 'Rol\RolController@getRols')->name('rols.list')->middleware('permiso:rol,view');
    Route::get('/rols/print', 'Rol\RolController@rolsPrint')->name('rols.rolsPrint')->middleware('permiso:rol,print');
    /*
    * Fin de las Rutas de Usuarios, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************
    /*
    * Rutas de Roles, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/modulos', 'Modulo\ModuloController@index')->name('modulos.index')->middleware('permiso:modulo,view');
    Route::get('/modulos/create', 'Modulo\ModuloController@create')->name('modulos.create')->middleware('permiso:modulo,add');
    Route::post('/modulos', 'Modulo\ModuloController@store')->name('modulos.store')->middleware('permiso:modulo,add');
    Route::get('/modulos/{modulo}/show', 'Modulo\ModuloController@show')->name('modulos.show')->middleware('permiso:modulo,view');
    Route::get('/modulos/{modulo}/edit', 'Modulo\ModuloController@edit')->name('modulos.edit')->middleware('permiso:modulo,edit');
    Route::post('/modulos/{modulo}', 'Modulo\ModuloController@update')->name('modulos.update')->middleware('permiso:modulo,update');
    Route::get('/modulos/{modulo}/delete', 'Modulo\ModuloController@destroy')->name('modulos.destroy')->middleware('permiso:modulo,delete');
    Route::get('/modulos/list', 'Modulo\ModuloController@getModulos')->name('modulos.list')->middleware('permiso:modulo,view');
    Route::get('/modulos/print', 'Modulo\ModuloController@modulosPrint')->name('modulos.modulosPrint')->middleware('permiso:modulo,print');
    /*
    * Fin de las Rutas de Usuarios, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************

    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard.dashboard');

});
// *********************************************************************************************************
    /*
    * FIN del Grupo Middleware para Autenticar y verifcar que tiene Permiso asociado a su Roll
    */
// *********************************************************************************************************

// La presente Ruta se encarga de validar los datos enviados al Correo de Usuario que se Registró
Route::get('register/confirm/{confirmation_code}', 'Auth\RegisterController@confirm')->name('auth.confirm');
// *********************************************************************************************************


/* Rutas de Control Diario, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
*/
Route::get('/solicitud', 'Solicitud\SolicitudController@index')->name('solicitud.index')->middleware('permiso:solicitud,view');
Route::get('/solicitud/create', 'Solicitud\SolicitudController@create')->name('solicitud.create')->middleware('permiso:solicitud,add');
Route::post('/solicitud', 'Solicitud\SolicitudController@store')->name('solicitud.store')->middleware('permiso:solicitud,add');
Route::get('/solicitud/{solicitud}/view', 'Solicitud\SolicitudController@view')->name('solicitud.view')->middleware('permiso:solicitud,view');
Route::get('/solicitud/{solicitud}/edit', 'Solicitud\SolicitudController@edit')->name('solicitud.edit')->middleware('permiso:solicitud,edit');
Route::post('/solicitud/{solicitud}', 'Solicitud\SolicitudController@update')->name('solicitud.update')->middleware('permiso:solicitud,update');
Route::get('/solicitud/{solicitud}/delete', 'Solicitud\SolicitudController@destroy')->name('solicitud.destroy')->middleware('permiso:solicitud,delete');
Route::get('/solicitud/getComunas', 'Solicitud\SolicitudController@getComunas')->name('getComunas2')->middleware('permiso:solicitud,view');
Route::get('/solicitud/getComunidad', 'Solicitud\SolicitudController@getComunidad')->name('getComunidad2')->middleware('permiso:solicitud,view');
Route::get('/solicitud/getCoodinacion', 'Solicitud\SolicitudController@getCoodinacion')->name('getCoodinacion2')->middleware('permiso:solicitud,view');
Route::get('/solicitud/list', 'Solicitud\SolicitudController@getSolicitud')->name('solicitud.list')->middleware('permiso:solicitud,view, edit');
Route::get('/solicitud/print', 'Solicitud\SolicitudController@solicitudPrint')->name('solicitud.solicitudPrint')->middleware('permiso:solicitud,print');
Route::get('/solicitud/solicitudTipo', 'Solicitud\SolicitudController@solicitudTipo')->name('solicitud.solicitudTipo');
Route::get('/solicitud/solicitudTipo2', 'Solicitud\SolicitudController@solicitudTipo2')->name('solicitud.solicitudTipo2');
Route::get('/solicitud/solicitudTipo3', 'Solicitud\SolicitudController@solicitudTipo3')->name('solicitud.solicitudTipo3');
Route::get('/solicitud/solicitudTipo4', 'Solicitud\SolicitudController@solicitudTipo4')->name('solicitud.solicitudTipo4');
Route::get('/solicitud/solicitudTipo5', 'Solicitud\SolicitudController@solicitudTipo5')->name('solicitud.solicitudTipo5');
Route::get('/solicitud/solicitudTotalTipo', 'Solicitud\SolicitudController@solicitudTotalTipo')->name('solicitud.solicitudTotalTipo');

Route::get('/solicitud/list2', 'Solicitud\SolicitudController@getSolicitud2')->name('solicitud.list2');
Route::get('/imprimir', 'Solicitud\SolicitudController@imprimir')->name('imprimir');

// ##############################rutas del seguimiento de la solicitud

Route::get('/seguimiento', 'Seguimiento\SeguimientoController@index')->name('seguimiento.index')->middleware('permiso:seguimiento,view');
Route::get('/seguimiento/create', 'Seguimiento\SeguimientoController@create')->name('seguimiento.create')->middleware('permiso:seguimiento,add');
Route::post('/seguimiento', 'Seguimiento\SeguimientoController@store')->name('seguimiento.store')->middleware('permiso:seguimiento,add');
Route::get('/seguimiento/{seguimiento}/view', 'Seguimiento\SeguimientoController@view')->name('seguimiento.view')->middleware('permiso:seguimiento,view');
Route::get('/seguimiento/{seguimiento}/edit', 'Seguimiento\SeguimientoController@edit')->name('seguimiento.edit')->middleware('permiso:seguimiento,edit');
Route::post('/seguimiento/{seguimiento}', 'Seguimiento\SeguimientoController@update')->name('seguimiento.update')->middleware('permiso:seguimiento,update');
Route::get('/seguimiento/update2', 'Seguimiento\SeguimientoController@update2')->name('update2')->middleware('permiso:seguimiento,update');
Route::get('/seguimiento/{seguimiento}/delete', 'Seguimiento\SeguimientoController@destroy')->name('seguimiento.destroy')->middleware('permiso:seguimiento,delete');
Route::get('/seguimiento/getComunas', 'Seguimiento\SeguimientoController@getComunas')->name('getComunas')->middleware('permiso:seguimiento,view');
Route::get('/seguimiento/getComunidad', 'Seguimiento\SeguimientoController@getComunidad')->name('getComunidad')->middleware('permiso:seguimiento,view');
Route::get('/seguimiento/getCoodinacion', 'Seguimiento\SeguimientoController@getCoodinacion')->name('getCoodinacion')->middleware('permiso:seguimiento,view');
Route::get('/seguimiento/list', 'Seguimiento\SeguimientoController@getSeguimiento')->name('seguimiento.list')->middleware('permiso:seguimiento,view');
Route::get('/seguimiento/print', 'Seguimiento\SeguimientoController@solicitudPrint')->name('seguimiento.solicitudPrint')->middleware('permiso:seguimiento,print');
Route::get('/seguimiento/solicitudTipo', 'Seguimiento\SeguimientoController@solicitudTipo')->name('seguimiento.solicitudTipo');
Route::get('/seguimiento/solicitudTotalTipo', 'Seguimiento\SeguimientoController@solicitudTotalTipo')->name('seguimiento.solicitudTotalTipo');
Route::post('/seguimiento/addSeguimiento', 'Seguimiento\SeguimientoController@addSeguimiento')->name('addSeguimiento')->middleware('permiso:seguimiento,view');
Route::get('/seguimientoapi', 'Seguimiento\SeguimientoController@segumientoJson')->name('seguimiento.segumientoapi');

Route::get('/seguimiento/list2', 'Seguimiento\SeguimientoController@getSeguimiento2')->name('seguimiento.list2');
// *********************************************************************************************************
