<?php
include 'db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$authorID = $data['authorID'];
$publishedIn = $data['publishedIn'];
$totalPages = $data['totalPages'];
$coverImageURL = $data['coverImageURL'];
$category = $data['category'];

if ($title && $authorID && $publishedIn && $totalPages && $coverImageURL && $category) {
    $stmt = $conn->prepare("INSERT INTO books (title, author_id, published_in, total_pages, cover_img_url, category_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $authorID, $publishedIn, $totalPages, $coverImageURL, $category);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Book added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding book to the database!']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data!']);
}

$conn->close();
?>