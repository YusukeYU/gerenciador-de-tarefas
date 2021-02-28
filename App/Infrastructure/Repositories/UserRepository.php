<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Connection;
use App\Infrastructure\Repositories\BaseRepository;
use App\Models\User;
use PDO;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new User();

    }

    public function createNewUser(array $data)
    {
/*
Cadastrando na tabela users
 */
        $sql = "INSERT INTO users (
                    email,
                    password)
                    VALUES (
                    :email,
                    :password)";

        $p_sql1 = Connection::getInstance()->prepare($sql);
        $p_sql1->bindValue(":email", $data["email_register"]);
        $p_sql1->bindValue(":password", $data["password_register"]);
        $p_sql1->execute();
/*
Cadastrando na tabela peoples
 */
        $sql = "INSERT INTO peoples (
                   name,
                   age,
                   document)
                   VALUES (
                   :name,
                   :age,
                   :document)";

        $p_sql1 = Connection::getInstance()->prepare($sql);
        $p_sql1->bindValue(":name", $data["name_register"]);
        $p_sql1->bindValue(":age", $data["age_register"]);
        $p_sql1->bindValue(":document", $data["document_register"]);
        $p_sql1->execute();
/*
Fazendo relação para tabela people_user
 */
        $sql = "SELECT MAX(id) FROM users";
        $p_sql1 = Connection::getInstance()->prepare($sql);
        $p_sql1->execute();
        $id_user = $p_sql1->fetch(PDO::FETCH_ASSOC);
        $sql = "SELECT MAX(id) FROM peoples";
        $p_sql1 = Connection::getInstance()->prepare($sql);
        $p_sql1->execute();
        $id_people = $p_sql1->fetch(PDO::FETCH_ASSOC);

        $sql = "INSERT INTO people_user (
            people_id,
            user_id)
            VALUES (
            :people_id,
            :user_id
             )";

        $p_sql1 = Connection::getInstance()->prepare($sql);
        $p_sql1->bindValue(":people_id", $id_people["MAX(id)"]);
        $p_sql1->bindValue(":user_id", $id_user["MAX(id)"]);
        $p_sql1->execute();

    }

}
