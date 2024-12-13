<?php

class Kernel {
    protected $request;
    protected $response;

    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function handle() {
        $uri = $this->request->getUri();
        $method = $this->request->getMethod();

        // Simple routing logic
        if ($uri === '/login' && $method === 'POST') {
            // Call the login controller method
            $this->login();
        } elseif ($uri === '/register' && $method === 'POST') {
            // Call the register controller method
            $this->register();
        } elseif ($uri === '/search' && $method === 'GET') {
            // Call the search controller method
            $this->search();
        } else {
            // Handle 404 Not Found
            $this->response->setStatusCode(404);
            $this->response->send("404 Not Found");
        }
    }

    protected function login() {
        // Logic for handling login
        $username = $this->request->getParam('username');
        $password = $this->request->getParam('password');
        // Authenticate user and respond accordingly
    }

    protected function register() {
        // Logic for handling registration
        $username = $this->request->getParam('username');
        $password = $this->request->getParam('password');
        // Register user and respond accordingly
    }

    protected function search() {
        // Logic for handling search
        $searchTerm = $this->request->getParam('search');
        // Perform search and respond with results
    }
}