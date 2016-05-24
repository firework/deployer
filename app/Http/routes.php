<?php
Route::auth();

Route::group(['middleware'=> 'auth'], function(){
    Route::get('/', 'DeployController@index');
    Route::post('/deploy', 'DeployController@deployIt');
    Route::get('/command', 'DeployController@deployCommand');
    Route::post('/save_command', 'DeployController@saveCommand');
    Route::get('/status', 'DeployController@status');
});
