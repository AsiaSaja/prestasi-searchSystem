<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];



    public function __construct()
    {
        $url = $this->parseURL();

        // controller
        if (isset($url) && is_array($url) && isset($url[0])) {
            if (file_exists('../app/controllers/' . $url[0] . '.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // method
        if (isset($url[1])) {
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            } else {
                echo "Method tidak ada atau bermasalah";
            }
        }

        // params
        if(!empty($url)) {
            $this->params = array_values($url);
            
        }

        // jalankan controller & method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);

    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
            // echo "Sebelum rtrim: $url<br>";
        
            // Menghilangkan '/' di akhir
            $url = rtrim($url, '/');
            // echo "Setelah rtrim: $url<br>";
        
            // Sanitasi URL
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // echo "Setelah sanitasi: $url<br>";
        
            // Memecah URL menjadi array
            $url = explode('/', $url);
            // echo "Setelah explode: ";
            // print_r($url);
            // echo "<br>";
        
            return $url;
        }
    }
}