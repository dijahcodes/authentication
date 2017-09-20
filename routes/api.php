<?php

use Illuminate\Http\Request;


Route::post('signup','AuthController@signUp');
Route::post('signIn', 'AuthController@signIn');
Route::get('getUser', 'AuthController@getUser');
Route::get('getLogs', 'LogController@index');
Route::post('storeLogs', 'LogController@store');
Route::get('showLogs/{id}', 'LogController@show');

Route::any('{path?}', 'MainController@index')->where("path", ".+");
