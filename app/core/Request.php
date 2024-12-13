<?php

class Request {
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getBody()
    {
        return $_POST;
    }

    public function getQueryParams()
    {
        return $_GET;
    }

    public function getParam($key)
    {
        return $_POST[$key] ?? $_GET[$key] ?? null;
    }
}