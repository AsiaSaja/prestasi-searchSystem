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
    // Extract data array into variables
    extract($data);
    
    $basePath = str_replace('/public', '/app/views', getcwd());
    $filePath = rtrim($basePath, '/') . '/' . ltrim($dir, '/') . '.php';
    
    error_log("View file path: $filePath");
    error_log("Data being passed to view: " . print_r($data, true));

    if (!file_exists($filePath)) {
        error_log("View file not found: $filePath");
        die("The requested view could not be loaded: $dir");
    }

    // Change require_once to require
    require $filePath;
}

function redirect($url)
{
    header("Location: " . BASEURL . '/' . ltrim($url, '/'));
    exit;
}