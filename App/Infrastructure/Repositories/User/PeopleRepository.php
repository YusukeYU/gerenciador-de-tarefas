<?php

namespace App\Infrastructure\Repositories\User;

use App\Infrastructure\Repositories\BaseRepository;
use App\Models\User\People;


class PeopleRepository extends BaseRepository
{
    public static $model;
    public function __construct()
    {
        PeopleRepository::$model = new People();
        parent::__construct();
    }
  

}
