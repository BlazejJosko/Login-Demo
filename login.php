<?php

$PATH = './logins/';

$postBody = [];

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    $postBody = json_decode(file_get_contents('php://input'), true);

    if(!isValidBody() || !checkUser()) {
        echo "no";
        return;
    }
 
    echo "ok";
}

function isValidBody(): bool {
    global $postBody;

    $error = false;

    $error = !isset($postBody["name"]) || empty($postBody["name"])
        || !isset($postBody["password"]) || empty($postBody["password"]) || preg_match('/[^a-zA-Z0-9]/', $postBody['name']);

    return !$error;
}

function checkUser(): bool {
    global $postBody;
    global $PATH;
    
    $filePath = $PATH . filter_var($postBody['name']);

    if(!file_exists($filePath)) {
        return false;
    }

    $file = file_get_contents($filePath);

    return password_verify($postBody['password'], $file);
}

?>