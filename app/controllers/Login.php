<?php

class Login extends Controller 
{
    public function index()
    {
        $this->view('login/index', ['title' => 'Login']);
    }

    public function process()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        //Validasi
        if( empty($username) || empty($password)) {
            $this->view('login/index', ['title' => 'login', 'error' => 'Username dan password wajib diisi.']);
            return;
        }

        //Panggil Model User
    }
}