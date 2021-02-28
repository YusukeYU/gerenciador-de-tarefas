<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Connection;
use Exception;
use PDO;
use App\Infrastructure\Interfaces\IBaseRepository;

abstract class BaseRepository implements IBaseRepository
{
    private $model;


    function __construct() {
        $this->model = static::$model;
    }

    public function all()
    {
        try {
            $this->__construct();
            $query = "SELECT * FROM " . $this->model->table;
            $this->model = Connection::getInstance()->prepare($query);
            $this->model->execute();
            return $this->model->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(array $data)
    {
            $this->__construct();
            //setamos o valor inicial da consulta sql
            $query = "INSERT INTO " .$this->model->table . " (";
            //identificamos quais campos estão sendo informados e acrescentamos a consulta sql
            foreach ($data as $field => $value) {
                $query = $query . "" . $field . ",";
            }
            //ajustamos a string feita
            $query = substr($query, 0, -1) . ") VALUES (";

            foreach ($data as $field => $value) {
                $query = $query . "'" . $value . "',";
            }


            //ajustamos a string feita novamente
            $query = substr($query, 0, -1) . ");";
            $this->model = Connection::getInstance()->prepare($query);
            return $this->model->execute();
    }

    public function delete($id)
    {
        try {
            $this->__construct();
            //setamos o valor inicial da consulta sql
            $query = "DELETE FROM  " . $this->model->table . " WHERE id = " . $id;
            $this->model = Connection::getInstance()->prepare($query);
            return $this->model->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function find($id , $colums = array('*'))
    {
        try {
            $this->__construct();
            $query = "SELECT ". implode(",",$colums) . " FROM "  . $this->model->table . " WHERE id = " . $id;
            $this->model = Connection::getInstance()->prepare($query);
            $this->model->execute();
            return $this->model->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function findBy($field, $value, $colums = array('*'))
    {
        try {
            $this->__construct();
            $query = "SELECT " . implode(",",$colums) . " FROM " . $this->model->table . " WHERE " . $field . " LIKE '" . $value . "%'";
            $this->model = Connection::getInstance()->prepare($query);
            $this->model->execute();
            return $this->model->fetch(PDO::FETCH_ASSOC); 
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function findByExactly($field, $value, $colums = array('*'))
    {
        try {
            $this->__construct();
            $query = "SELECT " . implode(",",$colums) . " FROM " . $this->model->table . " WHERE " . $field . " = '" . $value . "'";
            $this->model = Connection::getInstance()->prepare($query);
            $this->model->execute();
            return $this->model->fetch(PDO::FETCH_ASSOC); 
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(array $data)
    {
        try {
            $this->__construct();
            //setamos o valor inicial da consulta sql
            $query = "UPDATE " . $this->model->table . " SET ";
            //identificamos quais campos estão sendo informados e acrescentamos a consulta sql
            foreach ($data as $field => $value) {
                if ($field != 'id') {
                    $query = $query . " " . $field . " = '" . $value . "',";
                }
            }
            //ajustamos a string feita
            $query = substr($query, 0, -1) . " WHERE id = " . $data['id'];
            $this->model = Connection::getInstance()->prepare($query);
            return $this->model->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
