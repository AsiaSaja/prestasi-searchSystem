<?php
define('BASEURL', 'http://localhost/proyek-dev/public');
// var_dump(BASEURL);
// exit;

session_start();

// Tambahkan pengecekan akses halaman, misalnya:
if (!isset($_SESSION['user']) && $_SERVER['REQUEST_URI'] !== '/auth') {
    header('Location: ' . BASEURL . '/auth');
    exit;
}


require_once '../app/core/App.php';
require_once '../app/core/Controller.php';

require_once '../app/config/config.php';

require_once '../vendor/autoload.php';