<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:api')->get('user', 'Api\UserController@getUser');

// Comentario: Esta es la ruta que está causando el problema.
// Laravel 6.2 NO puede cachear rutas que usan una Closure (función anónima).
// Route::get('api/user', function (Request $request) {
//     return $request->user();
// });