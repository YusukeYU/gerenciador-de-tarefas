<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Infrastructure\Repositories\User\PeopleRepository;
use App\Infrastructure\Repositories\User\PeopleUserRepository;
use App\Infrastructure\Repositories\User\UserRepository;
use Exception;
use Src\Request;
use Src\View;
use Src\Auth;

class UserController extends Controller
{
    private $_userRepository;
    private $_peopleRepository;
    private $_peopleUserRepository;
    private $auth;
    public function __construct()
    {
        $this->_userRepository = new UserRepository();
        $this->_peopleRepository = new PeopleRepository();
        $this->_peopleUserRepository = new PeopleUserRepository();
        $this->auth = new Auth();
    }

    public function index()
    {
        echo View::render('index.php');
    }
    
    public function dashboard()
    {
        echo $this->auth->isLogged()? View::render('dashboard.php','Tasks'): header("Location: /");
    }
    public function logout()
    {
       $this->auth->logout();
       header("Location: /");
    }
 
    public function all()
    {
        try {
            $data = $this->_userRepository->all();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success("", [$data]);
    }
    public function find($id)
    {
        try {
            $data = $this->_userRepository->find($id);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success("", [$data]);
    }
    public function addUser(Request $request)
    {
        try {
            $data = $request->all();
            /**
             * Início das validações
             */
            if (in_array(null, $data)) {
                throw new Exception("Necessário informar todos os campos!");
            }

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                throw new Exception("O formato de e-mail inválido!");
            }

            if(!strlen($data['document']) == 11){
                throw new Exception("O formato de Cpf inválido!");
            }
            // filtra os dados recebidos e atribui a seus respectivos arrays
            $user = $request->only(['email', 'password']);
            $people = $request->only(['name', 'age', 'document']);
            //valida se o e-mail já se encontra cadastrado.
            if ($user_finded = $this->_userRepository->findByExactly('email', $user['email'], ['email'])) {
                throw new Exception("E-mail já cadastrado na base dados!");
            }
            //valida se o cpf já se encontra cadastrado.
            if ($people_finded = $this->_peopleRepository->findByExactly('document', $people['document'], ['document'])) {
                throw new Exception("CPF já cadastrado na base dados!");
            }
            //criptografa a senha do usuário
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
            //criamos o usuário
            $this->_userRepository->create($user);
            $this->_peopleRepository->create($people);
            /*
            Populamos a tabela de usuários e a de pessoas agora vamos configurar suas relações.
             */
            $id_user = $this->_userRepository->findByExactly('email', $user['email'], ['id']);
            $id_people = $this->_peopleRepository->findByExactly('document', $people['document'], ['id']);
            $this->_peopleUserRepository->create(['user_id' => $id_user['id'], 'people_id' => $id_people['id']]);
            $this->auth->setLogged($user,$people);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success("", []);
    }
}
