<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Infrastructure\Repositories\Task\TaskRepository;
use App\Infrastructure\Repositories\User\UserRepository;
use Exception;
use Src\Auth;
use Src\Request;

class TaskController extends Controller
{
    private $_taskRepository;
    private $_userRepository;
    private $auth;
    public function __construct()
    {
        $this->_taskRepository = new TaskRepository();
        $this->_userRepository = new UserRepository();
        $this->auth = new Auth();
    }


    public function all()
    {
        try {
            $user = $this->_userRepository->findBy('email', $_SESSION['user']['email'], ['id']);
            $tasks = $this->_taskRepository->findAllByExactly('user_id', $user['id'],['*'],'DATE ASC');
            $formated_tasks = [];
 
            //formatando as datas e inserindo no array
            foreach ($tasks as $task) {
                $date = new \DateTime($task['date']);
                $task['date'] = $date->format('d-m-Y H:i:s');
                $task['date'] = substr($task['date'], 0, -9) . ' às ' . substr($task['date'], 10, -3);
                array_push($formated_tasks, $task);
            }

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success("", [$formated_tasks]);
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

    public function addTask(Request $request)
    {
        try {
            $data = $request->all();
            /**
             * Início das validações
             */
            if (in_array(null, $data)) {
                throw new Exception("Necessário informar todos os campos!");
            }

            //criamos o usuário
            $data['date'] = $data['date_submit'] . ' ' . $data['time_submit'];
            unset($data['time']);
            unset($data['date_submit']);
            unset($data['time_submit']);
            $data['created_at'] = date("Y-m-d H:i:s");
            $user = $this->_userRepository->findBy('email', $_SESSION['user']['email'], ['id']);
            $data['user_id'] = $user['id'];
            $this->_taskRepository->create($data);

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success("", []);
    }
    public function deleteTask(Request $request)
    {
        try {
            $data = $request->only(['id']);
            $this->_taskRepository->delete($data['id']);
          
            if (in_array(null, $data)) {
                throw new Exception("Necessário informar um id!");
            }

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success('', [$data['id']]);
    }
}
