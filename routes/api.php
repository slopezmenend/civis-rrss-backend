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

//Muro del usuario
Route::get ('/muro/{id}', function ($id)
{
    return APIController::getMuro($id);
});

//Timeline del usuario
Route::get ('/timeline/{id}', function ($id)
{
    return APIController::getTimeline($id);
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

//get seguidos
Route::get ('/seguidos/{user_id}', function ($user_id)
{
    return APIController::getSeguidos($user_id);
});

//get siguiendo
Route::get ('/siguiendo/{user_id}', function ($user_id)
{
    return APIController::getSiguiendo($user_id);
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




