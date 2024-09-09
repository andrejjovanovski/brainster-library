<?php
include 'db.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $note_id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM notes WHERE id = ?");
    $stmt->bind_param("i", $note_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $note = $result->fetch_assoc();
            echo json_encode($note);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Note not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error fetching note: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No note ID provided']);
}

$conn->close();