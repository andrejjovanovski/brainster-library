<?php
include 'db.php';

header('Content-Type: application/json');

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data['id'])) {
    $note_id = intval($data['id']);

    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $note_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Note deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting note: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No note ID provided.']);
}

$conn->close();