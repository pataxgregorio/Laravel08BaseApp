<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Versión - 1, v1, de la API, para conectar con la Base de datos y realizar
 * las tareas necesaria, para que la aplicación funcione correctamente,
 * en este caso con PWA.
 * No eliminar la presente ruta, ya que al hacerlo dejara de funcionar la ruta
 * base de PWA.
 */ 
Route::group(['prefix' => 'v1'], function () {
    Route::get('/offline', function () {        
        return view('laravelpwa::offline');
    });
});

/**
 * Puede utilizar la presente API, para personalizar otras tareas,
 * le puede colocar otra Versión de ser necesario
 */ 
Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
    //    Route::resource('task', 'TasksController');

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_api_routes
});
