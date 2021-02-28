<?php

namespace Src;

use Exception;

class View
{
    /**
     * @Description : Função para renderizar arquivos front-end como htmls ou arquivos php.
     * @param $view = nome do arquivo, $path = pasta que ele se encontra.
     * @author Gustavo Pontes. 
     */
    public static function render($view, $path = 0)
    {
        try {
            if(!$path ==0){
                if (!file_exists("Public/". $path."/". $view)) {
                    throw new Exception('View não encontrada, por favor verifique o caminho fornecido.');
                }
                include "Public/". $path."/". $view;
            } else{
                if (!file_exists("Public/" . $view)) {
                    throw new Exception('View não encontrada, por favor verifique o caminho fornecido.');
                }
                include "Public/" . $view;
            }
                
        } catch (\Exception$e) {
            return $e->getMessage();
        }

    }
}
