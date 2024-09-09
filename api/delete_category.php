<?php
include 'db.php';

header('Content-Type: application/json');

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data['id'])) {
    $category_id = intval($data['id']);

    $stmt = $conn->prepare("UPDATE categories SET is_archived = 1 WHERE id = ?");
    $stmt->bind_param("i", $category_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting category: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No category ID provided.']);
}

$conn->close();