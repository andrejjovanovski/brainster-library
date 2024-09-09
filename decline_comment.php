<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
    header('Location: index.php');
    die();
}
require_once 'Comments/Comment.php';
use Comments\Comment as Comment;

if (isset($_GET['id'])) {
    $comment = new Comment();

    $comment->setId($_GET['id']);
    $comment->setIsApproved(2);
    $comment->declineComment();
    header('Location: ./comments.php');
}