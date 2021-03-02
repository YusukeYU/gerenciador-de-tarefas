<?php
 
error_reporting(E_ALL);
ini_set('display_errors', true);
 
require __DIR__ . '/vendor/autoload.php';
 
 
try {
 
    require __DIR__ . '/Routes/routes.php';
 
} catch(\Exception $e){
     
    echo $e->getMessage();
}