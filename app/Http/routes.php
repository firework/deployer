<?php
Route::auth();

Route::group(['middleware'=> 'auth'], function(){
    Route::get('/', 'DeployController@index');
    Route::post('deploy', 'DeployController@deployIt');
    Route::get('command', 'DeployController@deployCommand');
    Route::post('save_command', 'DeployController@saveCommand');
    Route::get('status', 'DeployController@status');

    Route::model('server', 'App\Server');
    Route::get('/server/{server}/destroy', ['as' => 'server.destroy', 'uses' => 'ServerController@destroy']);
    Route::resource('server', 'ServerController', ['except' => ['show', 'destroy']]);
});
