<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\APIController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\ReaccionController;
use App\Http\Controllers\UserController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => ['cors']], function () {
    // public routes

/** Resources */
Route::resource('comentario', ComentarioController::class);
Route::resource('follow', FollowController::class);
//search usuario
Route::post ('/postfollow/{seguido_id}/{seguidor_id}', function ($seguido_id, $seguidor_id)
{
    return FollowController::createFollow($seguido_id, $seguidor_id);
});

//search usuario
Route::delete ('/deletefollow/{seguido_id}/{seguidor_id}', function ($seguido_id, $seguidor_id)
{
    return FollowController::deleteFollow($seguido_id, $seguidor_id);
});

Route::resource('icon', IconController::class);
Route::resource('reaccion', ReaccionController::class);
Route::resource('user', UserController::class);

//Profile del usuario
Route::get ('/comentario/{comentario_id}/{uid}', function ($comentario_id, $uid)
{
    return APIController::getComentarios($comentario_id, $uid);
});

//Profile del usuario
Route::get ('/profile/{id}/{uid}', function ($id, $uid)
{
    return APIController::getProfile($id, $uid);
});

//Muro del usuario
Route::get ('/muro/{id}/{uid}', function ($id, $uid)
{
    return APIController::getMuro($id, $uid);
});

//Timeline del usuario
Route::get ('/timeline/{id}/{uid}', function ($id, $uid)
{
    return APIController::getTimeline($id, $uid);
});

//get seguidos
Route::get ('/seguidos/{user_id}/{uid}', function ($user_id, $uid)
{
    return APIController::getSeguidos($user_id, $uid);
});

//get siguiendo
Route::get ('/siguiendo/{user_id}/{uid}', function ($user_id, $uid)
{
    return APIController::getSiguiendo($user_id, $uid);
});

//Muro del usuario
Route::get ('/muro/{id}', function ($id)
{
    return APIController::getMuro($id, 0);
});

//Timeline del usuario
Route::get ('/timeline/{id}', function ($id)
{
    return APIController::getTimeline($id, 0);
});

//get seguidos
Route::get ('/seguidos/{user_id}', function ($user_id)
{
    return APIController::getSeguidos($user_id, 0);
});

//get siguiendo
Route::get ('/siguiendo/{user_id}', function ($user_id)
{
    return APIController::getSiguiendo($user_id, 0);
});

//datos del usuario
Route::get ('/getuser/{mail}', function ($mail)
{
    return APIController::getUserByEmail($mail);
});

//search usuario
Route::get ('/searchuser/{pattern}/{user_id}', function ($pattern, $user_id)
{
    return APIController::searchUser($pattern, $user_id);
});

//get usuario por email
Route::get ('/get-user/{email}', function ($email)
{
    return APIController::getUserByEmail($email);
});

Route::post ('/updateNameFoto/', function (Request $request)
{
    return APIController::updateNameFoto($request);
});

Route::post ('/crearReaccion/', function (Request $request)
{
    return APIController::crearReaccion($request);
});

Route::post ('/borrarReaccion/', function (Request $request)
{
    return APIController::borrarReaccion($request);
});

});


