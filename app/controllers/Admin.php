<?php

// // Include necessary core classes
// require_once '../core/Controller.php';
// require_once '../core/Request.php';
// require_once '../core/Response.php';
// require_once '../core/Session.php';
// require_once '../core/Constants.php'; // Include Constants.php

class Admin extends Controller {

    protected $response;
    private $db;
    protected $request;
    protected $session;

    public function __construct() {
        // parent::__construct();
        $this->db = new Database();
        $this->response = new Response(); // Instantiate Response class
        $this->request = new Request();   // Instantiate Request class
        $this->session = new Session();    // Instantiate Session class
    }

    // Method to show the login form
    public function login() {
        // Render the login view using the view function from Constants.php
        view('admin/login');
    }


    // Method to handle the login logic
    public function authenticate() {
        // Use the Request class to get POST data
        $username = $this->request->getParam('username');
        $password = $this->request->getParam('password');

        // Check credentials
        if ($this->checkCredentials($username, $password)) {
            // Set session variables
            $this->session->set('admin_logged_in', true);
            $this->session->set('admin_id', 1); // Set admin_id (or any unique identifier)
            $this->session->set('admin_username', $username);
            // Redirect to the admin dashboard using the redirect function from Constants.php
            redirect('/admin/dashboard');
        } else {
            // Redirect back to login with an error message using the redirect function
            redirect('/admin/login?error=invalid_credentials');
        }
    }

    public function register() {
        view('admin/register');
    }

    public function createAccount() {
        $username = $this->request->getParam('username');
        $password = $this->request->getParam('password');
        $confirmPassword = $this->request->getParam('confirmPassword');

        if (empty($username) || empty($password) || empty($confirmPassword)) {
            redirect('/admin/register?error=All fields are required');
            return;
        }

        if ($password !== $confirmPassword) {
            redirect('/admin/register?error=Passwords do not match');
            return;
        }

        if ($this->isUserNameTaken($username)) {
            redirect('/admin/register?error=Username is already taken');
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if ($this->createAdmin($username, $hashedPassword)) {

            $this->session->set('admin_logged_in', true);
            $this->session->set('admin_id', 1);
            $this->session->set('admin_username', $username);
            redirect('/admin/dashboard');
        } else {
            $this->session->set('errors', ['Registration failed, please try again.']);
        }
    }

    private function isUserNameTaken($username) {
        $user = $this->db->query("SELECT * FROM admins WHERE username = :username");
        $this->db->bind(':username', $username);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    private function createAdmin($username, $hashedPassword) {
        $this->db->query("INSERT INTO admins (username, password) VALUES (:username, :password)");
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $hashedPassword);
        return $this->db->execute();
    }

    // Method to show the admin dashboard
    public function dashboard() {
        // Check if admin is logged in
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
            exit;
        }
        // Render the admin dashboard view
        view('admin/dashboard');
    }

    // Method to manage students
    public function manageStudents() {
        // Check if admin is logged in
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
            exit;
        }
        // Load the Student model
        $studentModel = $this->model('Mahasiswa_Model');
        // Logic to retrieve and manage students
        $students = $studentModel->getAllStudents();
        view('admin/manage_students', ['students' => $students]);
    }

    // Method to manage competitions
    public function manageCompetitions() {
        // Check if admin is logged in
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
            exit;
        }
        // Load the Competition model
        $competitionModel = $this->model('Kompetisi_Model');
        // Logic to retrieve and manage competitions
        $competitions = $competitionModel->getAllCompetitions();
        view('admin/manage_competitions', ['competitions' => $competitions]);
    }

    // Method to manage achievements
    public function manageAchievements() {
        // Check if admin is logged in
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
            exit;
        }
        // Load the Achievement model
        $achievementModel = $this->model('Prestasi_Model');
        // Logic to retrieve and manage achievements
        $achievements = $achievementModel->getAllAchievements();
        view('admin/manage_achievements', ['achievements' => $achievements]);
    }

    
    // Method to log out
    public function logout() {
        // Destroy the session
        $this->session->destroy();
        // Redirect to the login page using the redirect function
        redirect('/admin/login');
    }

    // Method to check credentials (implement your own logic)
    private function checkCredentials($username, $password) {
        // Example: Check against hardcoded values (replace with database check)
        return $username === 'coba_admin' && $password === 'admin123#';
    }
}