<?php

use Illuminate\Support\Facades\Route;

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

//Route::group(['middleware' => ['cors']], function () {
    //Rutas a las que se permitirá acceso

    Auth::routes();
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@profile');

    Route::get('auth/meli', ['as' => 'auth/meli','uses'=>'AuthController@redirectToProvider']);
    Route::get('auth/meli/callback', ['as' => 'auth/meli/callback','uses'=>'AuthController@handleProviderCallback']);
    // Route::get('auth/meli', 'AuthController@redirectToProvider');
    // Route::get('auth/meli/callback', 'AuthController@handleProviderCallback');
    Route::get('meli/get', ['as' => 'meli/get','uses'=>'AuthController@queryget']);
    //Route::get('meli/get', 'AuthController@queryget');

    // Route::get('/publicar/buscar', 'HomeController@index');
    // Route::get('/publicar/masivo', 'HomeController@index');

    Route::get('publicar/buscar', ['as' => 'publicar/buscar','uses'=>'HomeController@index']);
    Route::get('publicar/masivo', ['as' => 'publicar/masivo','uses'=>'HomeController@index']);


//});

