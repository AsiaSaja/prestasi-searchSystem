<?php

class Controller {

    public function model($model)
    {
        require_once __DIR__ . '/../models/' . $model . '.php';

        // echo "Trying to load model: " . $model . "<br>";  // Debug output
        

        return new $model;
        
    }

    public function view($view, $data = [])
    {
        if (file_exists(__DIR__ . '/../app/views/' . $view . '.php')) {
            extract($data);

            require_once __DIR__ . '/../app/views/' . $view . '.php';

        } else {
            die('File view tidak ada');
        }
    }
}