<?php
include 'db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$note = $data['note'];
$clientID = $data['client_id'];
$bookID = $data['book_id'];

if (isset($note) && isset($clientID) && isset($bookID)) {
    $stmt = $conn->prepare("INSERT INTO notes (client_id, book_id, note) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $clientID, $bookID, $note);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Note added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Note already exists or database error!']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data!']);
}

$conn->close();