<?php

header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$title = $data->title;
$authorId = $data->authorID;
$totalPages = $data->totalPages;
$publishedIn = $data->publishedIn;
$categoryId = $data->category;
$coverImgUrl = $data->coverImageURL;

$sql = "UPDATE books SET title = ?, author_id = ?, total_pages = ?, published_in = ?, category_id = ?, cover_img_url = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiiisi", $title, $authorId, $totalPages, $publishedIn, $categoryId, $coverImgUrl, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update category']);
}