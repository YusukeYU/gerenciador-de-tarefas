<?php

namespace App\Infrastructure\Repositories\User;

use App\Infrastructure\Repositories\BaseRepository;
use App\Models\User\User;

class UserRepository extends BaseRepository
{
    public static $model;
    public function __construct()
    { 
        UserRepository::$model = new User();
        parent::__construct();
    }   

}
