<?php

$url = parse_url($_SERVER['REQUEST_URI']);
//echo var_export($url, true);

$root = './';

if ($url['path'] == '/oauth2/auth') {
    require_once $root . 'form_authorize.php';
}  elseif ($url['path'] == '/oauth2/authorize') {
    require_once $root . 'authorize.php';
}  elseif ($url['path'] == '/token') {
    require_once $root . 'token.php';
} else {
    require_once $root . '404.php';
}