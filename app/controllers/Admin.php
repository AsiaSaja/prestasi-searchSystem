<?php

class Admin extends Controller {

    protected $response;
    protected $request;
    protected $session;
    private $adminModel;
    private $mahasiswaModel;
    private $kompetisiModel;
    private $prestasiModel;
    private $logModel;

    public function __construct() {
        $this->response = new Response();
        $this->request = new Request();
        $this->session = new Session();
        $this->adminModel = $this->model('Admin_model');
        $this->mahasiswaModel = $this->model('Mahasiswa_model');
        $this->kompetisiModel = $this->model('Kompetisi_model');
        $this->prestasiModel = $this->model('Prestasi_model');
        $this->logModel = $this->model('LogModel');

    }
    
    public function index() {
        $this->dashboard();
        // $this->manageStudents();
        // $this->manageAchievements();
        // $this->manageCompetitions();
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
            
            $this->adminModel->logAction('insert', $adminId, 'admins', 'Created new admin: ' . $username);

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

        $data = [
            'judul' => 'Dashboard',
            'studentCount' => $this->mahasiswaModel->getCount(),
            'competitionCount' => $this->kompetisiModel->getCount(),
            'achievementCount' => $this->prestasiModel->getCount(),
            'recentLogs' => $this->adminModel->getRecentLogs(10), // Limit to 10 logs
        ];

        view('admin/dashboard', $data);


        

    }

    public function logout() {
        $this->session->destroy();
        redirect('/admin/login');
    }

    public function students()
    {

        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }

        $data = [
            'judul' => 'Manage Students',
            'students' => $this->mahasiswaModel->getAllStudents(),
        ];

        view('admin/students', $data);
    }

    public function createStudent() {
        // Handle the form data submission
        $name = $this->request->getParam('name');
        $nim = $this->request->getParam('nim');
        $email = $this->request->getParam('email');
        $program = $this->request->getParam('program');
        $year = $this->request->getParam('year');

        $fields = 'name, nim, email, program, year';
        $values = "'$name', '$nim', '$email', '$program', '$year'";
    
        // Validate the input and save to the database
        if ($this->mahasiswaModel->insert($fields, $values)) {
            // Redirect to students list after successful insertion
            // $studentId = $this->mahasiswaModel->getLastInsertId();

            // $this->logModel->logAction('create', $studentId, 'students', "Created new student with NIM $nim");

            redirect('/admin/students');
        } else {
            redirect('/admin/createStudent?error=Failed to add student');
        }
    }

    public function editStudent($id) {
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }

        if ($this->request->getMethod() == 'POST') {
            // Collect form data using the Request class
            $name = $this->request->getParam('name');
            $nim = $this->request->getParam('nim');
            $email = $this->request->getParam('email');
            $program = $this->request->getParam('program');
            $year = $this->request->getParam('year');
    
            // Prepare the SET part of the SQL UPDATE query
            $set = "name = '$name', nim = '$nim', email = '$email', program = '$program', year = '$year'";
    
            // Prepare the WHERE clause to identify the student to be updated
            $where = "id = $id";
    
            // Call the model's update method to update the student
            if ($this->mahasiswaModel->update($set, $where)) {
                // If update is successful, redirect to the student list

                // $this->logModel->logAction('update', $id, 'students', "Updated student with ID $id");
                redirect('/admin/students');
            } else {
                // If there was an error, redirect back to the edit page with an error message
                redirect('/admin/editStudent/'.$id.'?error=Failed to update student');
            }
        } else {
            // If it's a GET request, display the student edit form with the current student data
            $student = $this->mahasiswaModel->find("id = $id");
    
            // Pass the student data to the view for editing
            view('admin/editStudent', ['student' => $student]);
        }
    
    }

    public function deleteStudent($id) {
        if (!$this->session->isLoggedIn()) {
            $this->response->redirect('/admin/login');
        }
        
        $this->prestasiModel->delete("student_id = $id");

        // Call the model's delete method
        if ($this->mahasiswaModel->delete("id = $id")) {

            // $this->logModel->logAction('delete', $id, 'students', "Deleted student with ID $id");
            $this->response->redirect('/proyek-dev/public/admin/students');
            
        } else {
            $this->response->redirect('/proyek-dev/public/admin/students?error=Failed to delete student');
        }


    }
    

    public function competitions()
    {
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }
    
        $data = [
            'judul' => 'Manage Competitions',
            'competitions' => $this->kompetisiModel->getAllCompetitions(),
        ];
    
        view('admin/competitions', $data);
    }
    
    public function createCompetition() {
        $name = $this->request->getParam('name');
        $year = $this->request->getParam('year');
        $details = $this->request->getParam('details');
        $category = $this->request->getParam('category');
    
        $fields = 'name, year, details, category';
        $values = "'$name', '$year', '$details', '$category'";
    
        if ($this->kompetisiModel->insert($fields, $values)) {
            // $competitionId = $this->kompetisiModel->getLastInsertId();

            // $this->logModel->logAction('create', $competitionId, 'competitions', "Created new competition with name $name");
            redirect('/admin/competitions');
        } else {
            redirect('/admin/createCompetition?error=Failed to add competition');
        }
    }
    
    
    public function editCompetition($id) {
        error_log('Editing competition with ID: ' . $id);
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }
    
        if ($this->request->getMethod() == 'POST') {
            // Collect form data from the request
            $name = $this->request->getParam('name');
            $year = $this->request->getParam('year');
            $details = $this->request->getParam('details');
            $category = $this->request->getParam('category');

            error_log("Name: $name, Year: $year, Details: $details, Category: $category");
    
            // Prepare the SET part of the SQL UPDATE query
            $set = "name = '$name', year = '$year', details = '$details', category = '$category'";
    
            // Prepare the WHERE clause to identify the competition to be updated
            $where = "id = $id";
    
            // Call the model's update method to update the competition
            if ($this->kompetisiModel->update($set, $where)) {
                // If update is successful, redirect to the competition list
                // $this->logModel->logAction('update', $id, 'competitions', "Updated competition with ID $id");

                redirect('/admin/competitions');
            } else {
                // If there was an error, redirect back to the edit page with an error message
                redirect('/admin/editCompetition/'.$id.'?error=Failed to update competition');
            }
        } else {
            // If it's a GET request, display the competition edit form with the current competition data
            $competition = $this->kompetisiModel->find("id = $id");
            
    
            // Check if the competition exists
            if (!$competition) {
                redirect('/admin/competitions?error=Competition not found');
            }
    
            // Pass the competition data to the view for editing
            view('admin/editCompetition', ['competition' => $competition]);
        }
    }
    
    public function deleteCompetition($id) {
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }
    
        if ($this->kompetisiModel->delete("id = $id")) {
            // $this->logModel->logAction('delete', $id, 'competitions', "Deleted competition with ID $id");


            redirect('/admin/competitions');
        } else {
            redirect('/admin/competitions?error=Failed to delete competition');
        }
    }
    

    public function achievements()
    {
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }

        // Fetch the achievements, students, and competitions
        $students = $this->mahasiswaModel->getAllStudents();
        $competitions = $this->kompetisiModel->getAllCompetitions();
        $achievements = $this->prestasiModel->getAllAchievements();

        // var_dump($achievements);

        $data = [
            'judul' => 'Manage Achievements',
            'achievements' => $achievements,
            'students' => $students,
            'competitions' => $competitions,
        ];
        // var_dump($data['achievements']);
        // die();


        // Pass data to the view
        view('admin/achievements', $data);
    }

    
    

    // Add achievement
    public function createAchievement()
    {
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }

        $student_id = $this->request->getParam('student_id');
        $competition_id = $this->request->getParam('competition_id');
        $achievement = $this->request->getParam('achievement');

        $data = [
            'student_id' => $student_id,
            'competition_id' => $competition_id,
            'achievement' => $achievement,
        ];

        if ($this->prestasiModel->addAchievement($data)) {

            // $achievementId = $this->prestasiModel->getLastInsertId();

            // $this->logModel->logAction('create', $achievementId, 'achievements', "Created new achievement for student ID $student_id in competition ID $competition_id");            
            redirect('/admin/achievements');
        } else {
            redirect('/admin/achievements?error=Failed to add achievement');
        }
    }

    // Edit achievement
    public function editAchievement($id)
    {
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }
    
        // Fetch the achievement, student, and competition data
        $achievement = $this->prestasiModel->findAchievementById($id);
        $students = $this->mahasiswaModel->getAllStudents();
        $competitions = $this->kompetisiModel->getAllCompetitions();
    
        if (!$achievement) {
            // Handle the case where the achievement doesn't exist
            redirect('/admin/achievements');
        }
    
        $data = [
            'judul' => 'Edit Achievement',
            'achievement' => $achievement, // assuming findAchievementById returns an array
            'students' => $students,
            'competitions' => $competitions,
        ];

        $viewPath = 'admin/editAchievement';
        var_dump($viewPath);
    
        view($viewPath, $data);
    }
    

    // Delete achievement
    public function deleteAchievement($id)
    {
        if (!$this->session->isLoggedIn()) {
            redirect('/admin/login');
        }

        if ($this->prestasiModel->deleteAchievement($id)) {

            // $this->logModel->logAction('delete', $id, 'achievements', "Deleted achievement with ID $id");

            redirect('/admin/achievements');
        } else {
            redirect('/admin/achievements?error=Failed to delete achievement');
        }
    }

    
}
