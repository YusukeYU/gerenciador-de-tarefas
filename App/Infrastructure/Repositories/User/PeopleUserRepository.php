<?php

namespace App\Infrastructure\Repositories\User;

use App\Infrastructure\Repositories\BaseRepository;
use App\Models\User\PeopleUser;

class PeopleUserRepository extends BaseRepository
{
    public static $model;
    public function __construct()
    {
        PeopleUserRepository::$model = new PeopleUser();
        parent::__construct();
    }

}
