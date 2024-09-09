<?php
session_start();
require_once "./Comments/Comment.php";
use Comments\Comment as Comment;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: view_book.php');
    die('Invalid form request, Try Again!');
}

if (isset($_POST['bookID']) && isset($_POST['comment'])) {
    $comment = new Comment();
    $comment->setBookID($_POST['bookID']);
    $comment->setComment($_POST['comment']);
    $comment->setClientID($_SESSION['user']['id']);

    if (strlen($_POST['comment']) === 0) {
        $_SESSION['commentError'] = 'Field can\'t be empty';
        header("Location: view_book.php?id=1");
        die();
    }

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $result = $comment->addComment();

        // Ensure addComment was successful before redirecting
        if ($result) {
            header("Location: view_book.php?id=" . intval($id));
            die();
        } else {
            die('Failed to add comment');
        }
    } else {
        die('ID not set or empty');
    }
} else {
    die('bookID or comment not set');
}