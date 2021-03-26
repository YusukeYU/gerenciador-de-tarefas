<?php

namespace App\Infrastructure\Repositories\User;

use App\Infrastructure\Repositories\BaseRepository;
use App\Models\User\PasswordRecovery;

class PasswordRecoveryRepository extends BaseRepository
{
    public static $model;
    public function __construct()
    { 
        PasswordRecoveryRepository::$model = new PasswordRecovery();
        parent::__construct();
    }   

}
