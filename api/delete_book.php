<?php
include 'db.php';

header('Content-Type: application/json');

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data['id'])) {
    $book_id = intval($data['id']);

    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'book deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting book: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No book ID provided.']);
}

$conn->close();