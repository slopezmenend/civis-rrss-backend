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
Route::get ('/searchuser/{pattern}', function ($pattern)
{
    return APIController::searchUser($pattern);
});

