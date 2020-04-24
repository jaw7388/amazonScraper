<?php

use Illuminate\Support\Facades\Auth;
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
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('profile', 'HomeController@profile')->name('profile');
    Route::get('settings', 'HomeController@settings')->name('settings');
    Route::get('massiveproduct', 'HomeController@massiveProduct')->name('massiveproduct');
    Route::get('singleproduct', 'HomeController@singleProduct')->name('singleproduct');


    Route::get('auth/meli', ['as' => 'auth/meli','uses'=>'AuthController@redirectToProvider']);
    Route::get('auth/meli/callback', ['as' => 'auth/meli/callback','uses'=>'AuthController@handleProviderCallback']);
    Route::get('meli/get', ['as' => 'meli/get','uses'=>'AuthController@queryget']);

    Route::post('search/one', 'PostController@singleProduct')->name('search/one');
    
    Route::get('mlCategories', 'PostController@mlCategories')->name('mlCategories');
    Route::get('mlcategory/{id}', 'PostController@category')->name('mlcategory');
    Route::get('categoryatributes/{id}', 'PostController@categoryAtributes')->name('categoryatributes');
    
//});