<?php

class Response {
    public function setStatusCode($code)
    {
        http_response_code($code);
    }

    public function setHeader($header)
    {
        header($header);
    }

    public function send($body)
    {
        echo $body;
    }

    public function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }
}