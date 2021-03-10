<?php

namespace App\Infrastructure\Repositories\Task;

use App\Infrastructure\Repositories\BaseRepository;
use App\Models\Task\Task;

class TaskRepository extends BaseRepository
{
    public static $model;
    public function __construct()
    { 
        TaskRepository::$model = new Task();
        parent::__construct();
    }   

}
