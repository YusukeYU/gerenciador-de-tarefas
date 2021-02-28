<?php

namespace App\Controllers;

 class Controller
{
     

    public function success($message, $data)
    {
        header("HTTP/1.1 200 Ok");
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ]);
    }
    public function error($message)
    {
        header("HTTP/1.1 200 Ok");
        echo json_encode([
            'status' => 'error',
            'message' => $message,
            'data' => [],
        ]);
    }
}
