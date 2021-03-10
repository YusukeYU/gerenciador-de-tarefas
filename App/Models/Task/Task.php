<?php

namespace App\Models\Task;

class Task  {
    public $table = "tasks";
    private $title;
    private $created_at;
    private $description;
    private $date;
    private $user_id;
}