<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::post('/', 'HomeController@submit');

Route::get('home', 'HomeController@index');
Route::post('home', 'HomeController@submit');

Route::get('entries/{id}', 'HomeController@entries');

Route::get('validate' ,'HomeController@validateServer');

Route::get('upload/{id}', 'HomeController@upload');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
