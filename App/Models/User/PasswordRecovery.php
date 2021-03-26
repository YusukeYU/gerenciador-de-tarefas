<?php

namespace App\Models\User;

class PasswordRecovery  {
    public $table = "password_recovery";
    private $id;
    private $email;
    protected $token;
    protected $created_at;
}
