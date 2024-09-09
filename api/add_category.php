<?php
include 'db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$category_name = $data['name'];

if ($category_name) {
    $stmt = $conn->prepare("INSERT INTO categories (title) VALUES (?)");
    $stmt->bind_param("s", $category_name);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Category added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Category already exists or database error!']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data!']);
}

$conn->close();