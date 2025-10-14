<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

use Illuminate\Http\Request;

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::post('/home', 'HomeController@index');

Route::get('/error', 'HomeController@error');
Route::get('/about', 'HomeController@about');
Route::get('/profile', 'HomeController@profile');
Route::get('/games', 'GamesController@index');
Route::get('/addGame', 'GamesController@addGame');
Route::post('/editGame', 'GamesController@editGame');
Route::get('/editGrid', 'GamesController@editGrid');
Route::get('/editGame', 'GamesController@editGame');
Route::get('/acceptGame', 'GamesController@acceptGame');
Route::post('/updateGame', 'GamesController@updateGame');

/* API functions */
Route::post('/setVesselLocation', 'API\BattleshipsApiController@setVesselLocation');
Route::post('/removeVesselLocation', 'API\BattleshipsApiController@removeVesselLocation');
Route::post('/getGameStatus', 'API\BattleshipsApiController@getGameStatus');
Route::post('/markAsRead', 'API\BattleshipsApiController@markAsRead');