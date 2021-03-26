<?php 
use Src\Route as Route;

Route::post(['set' => '/task', 'as' => 'users.taskPost'], 'TaskController@addTask');

Route::get(['set' => '/task', 'as' => 'users.getTask'], 'TaskController@all');

Route::post(['set' => '/task/delete', 'as' => 'users.taskDelete'], 'TaskController@deleteTask');
?>