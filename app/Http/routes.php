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

Route::get('/', 'DeployController@index');
Route::post('/deploy', 'DeployController@deployIt');
Route::get('/deploy_command', 'DeployController@deployCommand');
