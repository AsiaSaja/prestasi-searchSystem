<?php

function base($dir = '')
{
    return str_replace('/public', '', getcwd()) . '/' . ltrim($dir, '/');
}

function asset($dir = '')
{
    return BASEURL . '/assets/' . ltrim($dir, '/');
}

function img($dir = '')
{
    return BASEURL . '/img/' . ltrim($dir, '/');
}

function url($dir = '')
{
    return BASEURL . '/' . ltrim($dir, '/');
}

function view($dir = '', $data = [])
{
    $basePath = str_replace('/public', '/app/views', getcwd());
    $filePath = rtrim($basePath, '/') . '/' . ltrim($dir, '/') . '.php';
    // var_dump($filePath);

    // Log the constructed file path
    error_log("View file path: $filePath");

    // if (!file_exists($filePath)) {
    //     die("The requested view could not be loaded: $dir");
    // }

    require_once $filePath;
}

function redirect($url)
{
    header("Location: " . BASEURL . '/' . ltrim($url, '/'));
    exit;
}