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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/get-news', 'HomeController@getNews')->name('getNews');
Route::get('news/{id}', 'NewsController@show')->name('showNews');
Route::group(['middleware' => 'isAdmin'], function () {
    Route::post('/uploadImg/{id}', 'NewsController@uploadImg')->name('uploadNewsImg');
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::resource('favorites', 'FavoritesController');
    // Users
//    Route::get('users', 'UserController@index')->middleware('isAdmin');
//    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
});
