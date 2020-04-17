<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Rotas de registro, login e logout de usuário
Route::prefix('/auth')->group(function(){
    Route::post('/register', 'api\v1\AuthController@register');
    Route::post('/login', 'api\v1\AuthController@login');
    Route::post('/logout', 'api\v1\AuthController@logout');
});

//Rotas para uso COM TOKEN
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('user', 'api\v1\AuthController@getAuthenticatedUser'); //retorna informaçoes do usuário com base no token

    Route::prefix('/user')->group(function () {
        Route::get('/index', 'api\v1\UserController@index'); 
        Route::get('/show/{id}', 'api\v1\UserController@show'); 
        Route::post('/store', 'api\v1\UserController@store'); 
        Route::put('/update/{id}', 'api\v1\UserController@update'); 
        Route::delete('/delete/{id}', 'api\v1\UserController@delete'); 
    });

    Route::prefix('/train')->group(function () {
        Route::get('/index', 'api\v1\TrainController@index'); 
        Route::get('/show/{id}', 'api\v1\TrainController@show'); 
        Route::post('/store', 'api\v1\TrainController@store'); 
        Route::put('/update/{id}', 'api\v1\TrainController@update'); 
        Route::delete('/delete/{id}', 'api\v1\TrainController@delete'); 
    });

    Route::prefix('/type_train')->group(function () {
        Route::get('/index', 'api\v1\TypeTrainController@index'); 
        Route::get('/show/{id}', 'api\v1\TypeTrainController@show'); 
        Route::post('/store', 'api\v1\TypeTrainController@store'); 
        Route::put('/update/{id}', 'api\v1\TypeTrainController@update'); 
        Route::delete('/delete/{id}', 'api\v1\TypeTrainController@delete'); 
    });
});
