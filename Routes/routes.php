<?php
use Src\Route as Route;


Route::get(['set' => '/', 'as' => 'users.login'], 'UserController@index');

Route::get(['set' => '/dashboard', 'as' => 'users.dashboard'], 'UserController@dashboard');

Route::post(['set' => '/', 'as' => 'users.create'], 'UserController@addUser');

Route::get(['set' => '/logout', 'as' => 'users.logout'], 'UserController@logout');

