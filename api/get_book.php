<?php

include 'db.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $book_id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $book = $result->fetch_assoc();
            echo json_encode($book);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Book not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error fetching book: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No book ID provided']);
}

$conn->close();