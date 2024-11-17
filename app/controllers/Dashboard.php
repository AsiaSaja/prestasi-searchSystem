<?php

class Dashboard extends Controller
{
    public function index()
    {
        session_start();

        // Cek apakah user sudah login
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $data['user'] = $_SESSION['user'];
        $this->view('dashboard/index', $data);
    }
}
