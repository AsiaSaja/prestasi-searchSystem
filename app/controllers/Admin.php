<?php

class Admin extends Controller {

    protected $response;
    protected $request;
    protected $session;
    private $adminModel;

    public function __construct() {
        $this->response = new Response();
        $this->request = new Request();
        $this->session = new Session();
        $this->adminModel = $this->model('Admin_model');
    }

    // Show the registration form
    public function register() {
        view('admin/register');
    }

    // Handle registration logic
    public function createAccount() {
        // Get form input
        $username = $this->request->getParam('username');
        $password = $this->request->getParam('password');
        $confirmPassword = $this->request->getParam('confirmPassword');

        // Validation
        if (empty($username) || empty($password) || empty($confirmPassword)) {
            redirect('/admin/register?error=All fields are required');
            return;
        }

        if ($password !== $confirmPassword) {
            redirect('/admin/register?error=Passwords do not match');
            return;
        }

        // Check if username is already taken
        if ($this->adminModel->usernameAlreadyExist($username)) {
            redirect('/admin/register?error=Username already exists');
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Save to the database
        if ($this->adminModel->createAdmin($username, $hashedPassword)) {
            // Get the last inserted admin ID
            $adminId = $this->adminModel->getLastInsertId();
            var_dump($adminId);

            // Set session variables for the logged-in admin
            $this->session->set('admin_logged_in', true);
            $this->session->set('admin_id', $adminId);
            $this->session->set('admin_username', $username);

            redirect('/admin/dashboard');
        } else {
            redirect('/admin/register?error=Failed to register, please try again');
        }
    }

    // Login logic
    public function login() {
        view('admin/login');
    }

    public function authenticate() {
        $username = $this->request->getParam('username');
        $password = $this->request->getParam('password');

        $admin = $this->adminModel->find("username = '$username'");

        if ($admin && password_verify($password, $admin['password'])) {
            $this->session->set('admin_logged_in', true);
            $this->session->set('admin_id', $admin['id']);
            $this->session->set('admin_username', $admin['username']);

            redirect('/admin/dashboard');
        } else {
            redirect('/admin/login?error=Invalid username or password');
        }
    }

    public function dashboard() {
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }

        view('admin/dashboard');
    }

    public function logout() {
        $this->session->destroy();
        redirect('/admin/login');
    }
}
