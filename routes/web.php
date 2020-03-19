<?php

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

Auth::routes();

//Route::get('/', 'HomeController@index')->name('home');
Route::get('/get-news', 'HomeController@getNews')->name('getNews');

Route::post('/news/{id}', 'NewsController@show')->name('showNews');

//Route::get('/downloadImg/{id}', 'NewsController@downloadImg')->name('downloadINewsImg');

//Route::post('/uploadImg/{id}', 'NewsController@uploadImg')->name('uploadNewsImg');


//Route::get('/getNew-news', '\App\Console\Commands\RssParserController@handle');

Route::get('/{any}', 'HomeController@index')->where('any', '.*');
