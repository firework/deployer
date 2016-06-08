<?php
Route::auth();

Route::group(['middleware'=> 'auth'], function(){
    Route::get('/', ['as' => 'home', 'uses' => 'DeployController@index']);
    Route::post('deploy', ['as' => 'deploy', 'uses' => 'DeployController@deployIt']);
    Route::get('command', ['as' => 'command', 'uses' => 'DeployController@deployCommand']);
    Route::post('save_command', ['as' => 'save.command', 'uses' => 'DeployController@saveCommand']);
    Route::get('status', ['as' => 'status', 'uses' => 'DeployController@status']);

    Route::model('server', 'App\Server');
    Route::get('server/{server}/destroy', ['as' => 'server.destroy', 'uses' => 'ServerController@destroy']);
    Route::resource('server', 'ServerController', ['except' => ['show', 'destroy']]);
});
