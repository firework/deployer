<?php
Route::auth();

Route::group(['middleware'=> 'auth'], function(){
    Route::get('/', ['as' => 'home', 'uses' => 'DeployController@index']);
    Route::post('deploy', ['as' => 'deploy', 'uses' => 'DeployController@deployIt']);
    Route::get('command', ['as' => 'command', 'uses' => 'DeployController@deployCommand']);
    Route::post('save_command', ['as' => 'save.command', 'uses' => 'DeployController@saveCommand']);
    Route::get('deploys', ['as' => 'deploys', 'uses' => 'DeployController@deploys']);

    Route::model('deploy', 'App\Models\Deploy');
    Route::get('deploy/{deploy}/status', ['as' => 'deploy.status', 'uses' => 'DeployController@deployStatus']);

    Route::model('server', 'App\Models\Server');
    Route::get('server/{server}/destroy', ['as' => 'server.destroy', 'uses' => 'ServerController@destroy']);
    Route::resource('server', 'ServerController', ['except' => ['show', 'destroy']]);
});
