<?php
require_once "./Clients/Client.php";

use Clients\Client as Client;
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Invalid form request, Try Again!';
    header('Location: view_book.php');
    die();
}

if (isset($_POST['user-credential']) && isset($_POST['password'])) {
    $client = new Client();
    $client->setUsername($_POST['user-credential']);
    $loggedInUser = $client->clientLogin();



    if ($loggedInUser) {
        if (password_verify($_POST['password'], $loggedInUser['password'])) {

            $_SESSION['user']['username'] = $loggedInUser['username'];
            $_SESSION['user']['isAdmin'] = $loggedInUser['is_admin'];
            $_SESSION['user']['name'] = $loggedInUser['name'];
            $_SESSION['user']['lastname'] = $loggedInUser['last_name'];
            $_SESSION['user']['id'] = $loggedInUser['id'];
            $_SESSION['user']['login-successful'] = 'success';
            if ($loggedInUser['is_admin'] === 1) {
                header('Location: admin-dashboard.php');
            } else {
                header('Location: index.php');
            }
            die();
        } else {
            $_SESSION['loginValidationError']['password'] = 'Incorrect password';
            header('Location: ./login.php');
        }
    } else {
        $_SESSION['loginValidationError']['username'] = 'Username not registered!';
        header('Location: ./login.php');
    }


}
