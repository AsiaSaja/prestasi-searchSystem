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
    
    public function search() {
        // Retrieve input parameters safely using $_GET, and sanitize them
        $keyword = htmlspecialchars($this->request->getParam('keyword')) ?? ''; // Sanitize
        $category = htmlspecialchars($this->request->getParam('category')) ?? null;

        // Call the search function from the loaded model
        $results = $this->prestasiModel->search($keyword, $category);

        // Pass the results to the view
        view('home/search_results', ['results' => $results]);
    }
}

