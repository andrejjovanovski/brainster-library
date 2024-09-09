<?php
session_start();
require_once 'Comments/Comment.php';
use Comments\Comment as Comment;

$comment = new Comment();
$comment->setId($_GET['commentId']);

$deletedComment = $comment->deleteComment();

//if ($deletedComment) {
//    $_SESSION['deletedComment'] = 'Comment Deleted';
//} else {
//    $_SESSION['deleteVehicleError'] = 'Comment can\'t be deleted';
//}

header("Location: view_book.php?id=" . intval($_GET['id']));
return;


