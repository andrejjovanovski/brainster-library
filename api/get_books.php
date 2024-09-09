<?php

include 'db.php';

header('Content-Type: application/json');

$sql = "SELECT books.*, a.id as book_author_id, a.name as book_author_name, a.last_name as book_author_lastname, c.id as book_category_id, c.title as book_category_title FROM books
        JOIN authors a on a.id = books.author_id
        JOIN library.categories c on c.id = books.category_id";
$result = $conn->query($sql);

$authors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $authors[] = $row;
    }
}

echo json_encode($authors);

$conn->close();