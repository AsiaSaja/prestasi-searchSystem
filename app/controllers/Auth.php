<?php

class Auth extends Controller {
    public function __construct()
    {
        // Pastikan session hanya dimulai sekali
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        // Jika sudah login, redirect ke /home
        if (isset($_SESSION['user'])) {
            header('Location: ' . $_ENV['BASEURL'] . '/home');
            exit;
        }

        // Tampilkan view login
        $this->view('auth/login', ['error' => $_SESSION['error'] ?? null]);
        unset($_SESSION['error']); // Hapus pesan error setelah ditampilkan
    }

    public function login()
    {
        // Ambil input
        $nim = trim($_POST['nim']);
        $password = trim($_POST['password']);

        // Validasi input
        if (empty($nim) || empty($password)) {
            $_SESSION['error'] = 'NIM dan Password harus diisi';
            header('Location: ' . $_ENV['BASEURL'] . '/auth');
            exit;
        }

        // Cari user berdasarkan NIM
        $user = $this->model('User_model')->getUserByNim($nim);

        // Verifikasi password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: ' . $_ENV['BASEURL'] . '/home');
            exit;
        } else {
            $_SESSION['error'] = 'NIM atau Password salah';
            header('Location: ' . $_ENV['BASEURL'] . '/auth');
            exit;
        }
    }

    public function forgot()
    {
        // Tampilkan form forgot password
        $this->view('auth/forgot', ['error' => $_SESSION['error'] ?? null]);
        unset($_SESSION['error']);
    }

    public function reset()
    {
        // Ambil input
        $nim = trim($_POST['nim']);
        $email = trim($_POST['email']);

        // Validasi input
        if (empty($nim) || empty($email)) {
            $_SESSION['error'] = 'NIM dan Email harus diisi';
            header('Location: ' . $_ENV['BASEURL'] . '/auth/forgot');
            exit;
        }

        // Cari user berdasarkan NIM dan Email
        $user = $this->model('User_model')->getUserByNimAndEmail($nim, $email);

        if ($user) {
            // Placeholder untuk logika reset password
            // Contoh: generate password baru atau kirim email reset
            $_SESSION['success'] = 'Link reset password telah dikirim ke email Anda';
            header('Location: ' . $_ENV['BASEURL'] . '/auth');
            exit;
        } else {
            $_SESSION['error'] = 'NIM atau Email tidak ditemukan';
            header('Location: ' . $_ENV['BASEURL'] . '/auth/forgot');
            exit;
        }
    }

    public function logout()
    {
        // Hancurkan sesi
        session_destroy();
        header('Location: ' . $_ENV['BASEURL'] . '/auth');
        exit;
    }
}
