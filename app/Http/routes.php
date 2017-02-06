<?php
Route::auth();

Route::group(['middleware'=> 'auth'], function(){
    Route::get('/', ['as' => 'home', 'uses' => 'DeployController@index']);
    Route::post('deploy', ['as' => 'deploy', 'uses' => 'DeployController@deployIt']);
    Route::get('command', ['as' => 'command', 'uses' => 'DeployController@deployCommand']);
    Route::post('save_command', ['as' => 'save.command', 'uses' => 'DeployController@saveCommand']);
    Route::get('deploys', ['as' => 'deploys', 'uses' => 'DeployController@deploys']);

    Route::model('integration', 'App\Models\SlackIntegration');
    Route::get('integration/{integration}/destroy', ['as' => 'integration.destroy', 'uses' => 'SlackIntegrationController@destroy']);
    Route::resource('integration', 'SlackIntegrationController', ['except' => ['show', 'destroy']]);

    Route::model('deploy', 'App\Models\Deploy');
    Route::get('deploy/{deploy}/status', ['as' => 'deploy.status', 'uses' => 'DeployController@deployStatus']);

    Route::model('server', 'App\Models\Server');
    Route::get('server/{server}/destroy', ['as' => 'server.destroy', 'uses' => 'ServerController@destroy']);
    Route::get('server/{server}/info', ['as' => 'server.info', 'uses' => 'ServerController@info']);
    Route::resource('server', 'ServerController', ['except' => ['show', 'destroy']]);

    Route::model('task', 'App\Models\Task');
    Route::get('task/{task}/destroy', ['as' => 'task.destroy', 'uses' => 'TaskController@destroy']);
    Route::resource('task', 'TaskController', ['except' => ['show', 'destroy']]);
});
