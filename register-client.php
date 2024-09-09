<?php
session_start();
require_once "Clients/Client.php";

use Clients\Client as Client;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Invalid form request, Try Again!';
    header('Location: register.php');
    die();
}
if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {

    var_dump($_POST);
    $validationError = false;
    $_SESSION['registerErrorMessages'] = [];

    if (strlen($_POST['name']) === 0) {
        $validationError = true;
        $_SESSION['registerErrorMessages']['name'] = "Field can't be empty";
    }

    if (strlen($_POST['lastname']) === 0) {
        $validationError = true;
        $_SESSION['registerErrorMessages']['lastname'] = "Field can't be empty";
    }

    if (strlen($_POST['username']) === 0) {
        $validationError = true;
        $_SESSION['registerErrorMessages']['username'] = "Field can't be empty";
    } else if (strlen($_POST['username'] < 4)) {
        $validationError = true;
        $_SESSION['registerErrorMessages']['username'] = "Username need to be at least 3 characters long";
    } else if (strlen($_POST['username'] > 13)) {
        $validationError = true;
        $_SESSION['registerErrorMessages']['username'] = "Too long! Max characters 12";
    }

    if (strlen($_POST['email']) === 0) {
        $_SESSION['registerErrorMessages']['email'] = "Field can't be empty";
        $validationError = true;
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['registerErrorMessages']['email'] = "Email not valid";
        $validationError = true;
    }

    if (strlen($_POST['password']) === 0) {
        $validationError = true;
        $_SESSION['registerErrorMessages']['password'] = "Field can't be empty";
    }

    if (strlen($_POST['confirmPassword']) === 0) {
        $validationError = true;
        $_SESSION['registerErrorMessages']['confirmPassword'] = "Field can't be empty";
    }

    if ($_POST['password'] !== $_POST['confirmPassword']) {
        $validationError = true;
        $_SESSION['registerErrorMessages']['confirmPassword'] = "Passwords don't match";
    }

    var_dump($validationError, $_SESSION);


    if ($validationError) {
        var_dump($validationError, $_SESSION);
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $client = new Client();
        $client->setName($_POST['name']);
        $client->setLastname($_POST['lastname']);
        $client->setEmail($_POST['email']);
        $client->setUsername($_POST['username']);
        $client->setPassword($hashedPassword);


        if ($client->registerNewClient()) {
            header('Location: login.php');
        }
    }
}





