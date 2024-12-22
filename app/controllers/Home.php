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
        $data = [];
        view('home/index', $data);
    }

    // In Home.php controller
    public function search() 
    {
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        $searchResults = $this->prestasiModel->searchAchievement($keyword);
        
        $data = [
            'keyword' => $keyword,
            'searchResults' => $searchResults
        ];
        
        view('home/index', $data);
    }

}
