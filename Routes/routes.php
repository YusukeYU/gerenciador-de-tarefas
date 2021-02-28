<?php
use Src\Route as Route;
use Src\View;


Route::get(['set' => '/', 'as' => 'users.login'], function(){
    echo View::render('index.html');
});

Route::post(['set' => '/', 'as' => 'users.create'], 'UserController@createNewUser');

Route::get(['set' => '/teste', 'as' => 'users.login2'], function(){
      echo View::render('index.html','Users');
});

