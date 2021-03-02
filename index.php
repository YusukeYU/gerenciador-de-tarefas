<?php
 
require "bootstrap.php";
 
use Src\Route as Route;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
$request = new Src\Request;
 
Route::resolve($request);

