<?php

class ForgotPassword extends Controller
{
    public function index()
    {
        $this->view('auth/forgot_password');
    }

    public function sendResetLink()
    {
        $email = $_POST['email'];

        $model = $this->model('Mahasiswa_model');
        $user = $model->getMahasiswaByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(50)); // Generate token
            $model->setResetToken($email, $token);

            // Kirim email
            $resetLink = BASEURL . "/forgotpassword/reset?token=$token";
            $subject = "Reset Password Anda";
            $message = "Klik link berikut untuk reset password Anda: $resetLink";
            $headers = "From: no-reply@yourwebsite.com";

            mail($email, $subject, $message, $headers);

            $_SESSION['message'] = 'Link reset password telah dikirim ke email Anda.';
            header('Location: ' . BASEURL . '/forgotpassword');
        } else {
            $_SESSION['error'] = 'Email tidak ditemukan!';
            header('Location: ' . BASEURL . '/forgotpassword');
        }
    }

    public function reset()
    {
        $token = $_GET['token'];
        $model = $this->model('Mahasiswa_model');
        $user = $model->getUserByToken($token);

        if ($user) {
            $data['email'] = $user['email'];
            $this->view('auth/reset_password', $data);
        } else {
            $_SESSION['error'] = 'Token tidak valid!';
            header('Location: ' . BASEURL . '/auth');
        }
    }

    public function updatePassword()
    {
        $email = $_POST['email'];
        $newPassword = $_POST['password'];

        $model = $this->model('Mahasiswa_model');
        $model->updatePassword($email, $newPassword);

        $_SESSION['message'] = 'Password berhasil diubah. Silakan login kembali.';
        header('Location: ' . BASEURL . '/auth');
    }
}
