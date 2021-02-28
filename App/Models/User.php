<?php

namespace App\Models;

class User  {
    public $table = "users";
    private $id;
    private $name;
    private $email;
    protected $password;
}