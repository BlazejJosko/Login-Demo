<?php

$PATH = './logins/';

$errors = [];
$postBody = [];

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    $postBody = json_decode(file_get_contents('php://input'), true);

    if(isValidBody()) {
        // sanitize input and safe in db
        saveUser();
    }

    echo json_encode($errors);
}

function isValidBody(): bool {
    global $errors;
    global $postBody;

    $error = false;

    if(!isset($postBody["name"]) || empty($postBody["name"])) {
        $errors["name"] = "Bitte gebe einen Namen ein.";
        $error = true;
    }

    if(preg_match('/[^a-zA-Z0-9]/', $postBody['name'])) {
        $errors["name"] = "Bitte keine Sonderzeichen verweden.";
        $error = true;
    }

    if(!isset($postBody["password"]) || empty($postBody["password"])) {
        $errors["password"] = "Bitte gebe ein Passwort ein.";
        $error = true;
    }

    if(!isset($postBody["password2"]) || empty($postBody["password2"]) || $postBody["password2"] != $postBody["password"]) {
        $errors["password2"] = "Die Passwörter stimmen nicht überein.";
        $error = true;
    }

    return !$error;
}

function saveUser() {
    global $postBody;
    global $PATH;
    global $errors;

    $filePath = $PATH . filter_var($postBody['name']);

    if(file_exists($filePath)) {
        $errors['name'] = 'Dieser Nutzername ist nicht verfügbar.';
        return;
    }

    $file = fopen($filePath, 'w');
    fwrite($file, password_hash($postBody['password'], PASSWORD_DEFAULT));
    fclose($file);
}

?>