<?php

use Illuminate\Http\Request;


Route::post('signUp','AuthController@signUp');
Route::post('signIn', 'AuthController@signIn');
Route::get('getUser', 'AuthController@getUser');
Route::get('getLogs', 'LogController@index');
Route::post('storeLog', 'LogController@store');
Route::get('showLogs/{id}', 'LogController@show');
Route::get('getLogss', 'LogController@getLogs');

Route::any('{path?}', 'MainController@index')->where("path", ".+");
