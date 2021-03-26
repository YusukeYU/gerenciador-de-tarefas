<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Infrastructure\Repositories\User\PeopleRepository;
use App\Infrastructure\Repositories\User\PeopleUserRepository;
use App\Infrastructure\Repositories\User\UserRepository;
use App\Infrastructure\Repositories\User\PasswordRecoveryRepository;
use Exception;
use Src\Auth;
use Src\Request;
use Src\View;
use Src\Mailer;

class UserController extends Controller
{
    private $_userRepository;
    private $_peopleRepository;
    private $_peopleUserRepository;
    private $_passwordRecoveryRepository;
    private $auth;
    public function __construct()
    {
        $this->_userRepository = new UserRepository();
        $this->_peopleRepository = new PeopleRepository();
        $this->_peopleUserRepository = new PeopleUserRepository();
        $this->_passwordRecoveryRepository = new PasswordRecoveryRepository();
        $this->auth = new Auth();
    }

    public function index()
    {
        echo $this->auth->isLogged() ? View::render('dashboard.html', 'Tasks') : View::render('index.html');
    }

    public function dashboard()
    {
        echo $this->auth->isLogged() ? View::render('dashboard.html', 'Tasks') : header("Location: /");
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

    public function login(Request $request)
    {

        try {
            $data = $request->only(['email', 'password']);
            if (in_array(null, $data)) {
                throw new Exception("Necessário informar todos os campos!");
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("O formato de e-mail inválido!");
            }
            $user = $this->_userRepository->userLogin($data);
            $people_user_id = $this->_peopleUserRepository->findBy('user_id', $user['id'], ['people_id']);
            $people = $this->_peopleRepository->find($people_user_id['people_id']);
            $this->auth->setLogged($user, $people);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

        return $this->success("Logado com sucesso!", []);
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

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("O formato de e-mail inválido!");
            }

            if (!strlen($data['document']) == 11) {
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
            $this->auth->setLogged($user, $people);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success("", []);
    }

    public function userPasswordRecovery(Request $request)
    {

        try {
            $data = $request->only(['email']);
            // valida se o dado recebido é nulo
            if (in_array(null, $data)) {
                throw new Exception("Necessário informar todos os campos!");
            }
            // valida se o formato enviado é realmente um e-mail
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("O formato de e-mail inválido!");
            }
            //valida se o e-mail já se encontra cadastrado.
            if (!$user_finded = $this->_userRepository->findByExactly('email', $data['email'], ['email'])) {
                throw new Exception("E-mail não cadastrado base dados!");
            }
            //cria um token aleátório para esta recuperação
            $data['token'] = sha1(uniqid(mt_rand(), true));
            // pega data atual
            date_default_timezone_set('America/Sao_Paulo');
            $data['created_at'] = date('y/m/d H:i:s');
            // cria token criptografado
            $link = "http://localhost/recovery/" . $data["token"];
            // envia o token por email
            $mail = new Mailer();
            if ($mail->sendMailResetPassword($data['email'], $link) != 1) {
                throw new Exception("Houve um erro ao enviar o e-mail de recuperação, por favor, contate o administrador.");
            }
            //salva o token na base de dados
            $this->_passwordRecoveryRepository->create($data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

        return $this->success("Um e-mail com instruções foi encaminhado para você, verifique em sua caixa de entrada ou caixa de spam!", []);
    }

    public function recoveryView($token)
    {
        //verifica se o token informado existe no banco de dados
        if (!$request = $this->_passwordRecoveryRepository->findByExactly('token', $token)) {
            header("Location: /");
        }
        // verifica se o token está expirado
        date_default_timezone_set('America/Sao_Paulo');
        if (time() - strtotime($request['created_at']) > 10 * 60) {
            header("Location: /");
        }
        View::render('newPassword.php','Mail',['email' => $request['email'],'token' =>$token]);
    }
}
