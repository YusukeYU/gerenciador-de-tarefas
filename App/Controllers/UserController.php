<?php

namespace App\Controllers;

use App\Infrastructure\Repositories\UserRepository;
use Exception;
use App\Controllers\Controller;
use Src\Request;

class UserController extends Controller
{
    private $_userRepository;

    public function __construct()
    {
        $this->_userRepository = new UserRepository();
    }

    public function index()
    {
        try {
          $data = $this->_userRepository->update(['name' =>'teste2', 'id' =>3]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success("", [$data]);
    }

    public function all(){
        try {
            $data = $this->_userRepository->all() ;
          } catch (Exception $e) {
              return $this->error($e->getMessage());
          }
          return $this->success("", [$data]);
    }
    public function find($id){
        try {
            $data = $this->_userRepository->find($id) ;
          } catch (Exception $e) {
              return $this->error($e->getMessage());
          }
          return $this->success("", [$data]);
    }
    public function createNewUser(Request $request){
        try {
            $data = $request->all();
            if (in_array(null, $data)) {
                throw new Exception("Necessário preencher todos os campos!");
            }
            $data['password_register'] =  password_hash($data['password_register'],PASSWORD_DEFAULT);
            
             $this->_userRepository->createNewUser($data) ;
         
          } catch (Exception $e) {
              return $this->error($e->getMessage());
          }
          return $this->success("", []);
    }
}
