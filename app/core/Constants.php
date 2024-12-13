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

function view($dir = '', $data = [], $title = 'Tracking')
{
    require_once(str_replace('/public', '/app/views/', getcwd()) . '/' . ltrim($dir, '/') . '.php');
}

function redirect($url)
{
    header("Location: " . BASEURL . '/' . ltrim($url, '/'));
    exit;
}