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

Route::post('/login', ['as' => 'login', 'uses' => 'Api\LoginController@login']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'Api\LoginController@logout']);

//panel - authenticated routes
Route::group(['middleware' => 'api'], function () {
    //login jwt refresh
    Route::put('/refresh', 'Api\LoginController@refresh');
    //users routes
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['as' => 'users', 'uses' => 'Api\UsersController@index']);
        Route::post('/add', ['as' => 'add_user', 'uses' => 'Api\UsersController@add']);
        Route::post('/update/{id}', ['as' => 'update_user', 'uses' => 'Api\UsersController@update']);
        Route::get('/delete/{id}', ['as' => 'delete_user', 'uses' => 'Api\UsersController@delete']);
    });
    //products routes
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', ['as' => 'products', 'uses' => 'Api\ProductsController@index']);
        Route::post('/add', ['as' => 'add_product', 'uses' => 'Api\ProductsController@add']);
        Route::post('/update/{id}', ['as' => 'update_product', 'uses' => 'Api\ProductsController@update']);
        Route::get('/delete/{id}', ['as' => 'delete_product', 'uses' => 'Api\ProductsController@delete']);
    });
});

