<?php

namespace Src;

class Auth{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

     /**
     * @Description : Função verifica se o usuário está logado e retorna true ou false.
     * @param none 
     * @author Gustavo Pontes. 
     */
    public function isLogged(){
        $_SESSION['logged'] =  isset($_SESSION['logged']) ? $_SESSION['logged'] : '0';
        return $_SESSION['logged'] =='1'? true : false;
    }

    public function setLogged($user,$people){
        $_SESSION['logged'] = '1';
        $_SESSION['user']['email'] = $user['email'];
        $_SESSION['people']['document'] = $people['document'];
        $_SESSION['people']['name'] = $people['name'];
    }
    public function logout(){
        session_destroy();
    }
}