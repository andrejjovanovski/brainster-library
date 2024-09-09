<?php
include 'db.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $author_id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM authors WHERE id = ?");
    $stmt->bind_param("i", $author_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $author = $result->fetch_assoc();
            echo json_encode($author);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Author not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error fetching Author: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No author ID provided']);
}

$conn->close();