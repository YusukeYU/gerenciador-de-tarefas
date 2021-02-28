<?php

namespace App\Infrastructure\Interfaces;

interface IBaseRepository {
    public function create(array $data);
    public function delete($id);
    public function update(array $data);
    public function find($id ,$colums = array('*') );
    public function findBy($field , $value, $colums = array('*'));
}