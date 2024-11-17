<?php

class Home extends Controller {
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $data['user'] = $_SESSION['user'];
        $this->view('home/index', $data);
    }
}
