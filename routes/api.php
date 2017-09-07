<?php

use Illuminate\Http\Request;


Route::post('signup','AuthController@signUp');
Route::post('signIn', 'AuthController@signIn');
Route::get('getUser', 'AuthController@getUser');

Route::any('{path?}', 'MainController@index')->where("path", ".+");
