<?php

class Home extends Controller {
    protected $response;
    protected $request;
    protected $session;
    private $prestasiModel;

    public function __construct() {
        $this->response = new Response();
        $this->request = new Request();
        $this->session = new Session();
        $this->prestasiModel = $this->model('Prestasi_model');
    }

    public function index() {
        // Simply load the homepage view
        view('home/index');
    }

    // In Home.php controller
    public function search() 
    {
        // Check if the form was submitted with a keyword
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        
        // Log the keyword for debugging
        error_log("Search performed with keyword: " . $keyword);
        
        // Proceed with search if keyword exists
        $data['searchResults'] = $this->prestasiModel->searchAchievement($keyword);
        $data['keyword'] = $keyword;
        
        view('home/index', $data);
        
    }
    

}
